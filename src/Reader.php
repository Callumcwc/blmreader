<?php

namespace Renedekat\Blm;

use Illuminate\Support\Collection;
use Renedekat\Blm\Exceptions\InvalidBlmFileException;
use Renedekat\Blm\Exceptions\InvalidBlmStringException;
use Renedekat\PHPVerbalExpressions\VerbalExpressions;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Reader
{
    const CONTAINS_HEADERS = 1;
    const CONTAINS_DEFINITIONS = 2;
    const CONTAINS_DATA = 4;

    /**
     * @var string Raw contents
     */
    protected $contents = null;

    /**
     * @var Collection Parsed header
     */
    protected $headers = null;

    /**
     * @var Collection Parsed definition
     */
    protected $definitions = null;

    /**
     * @var Collection Parsed data
     */
    protected $data = null;

    /**
     * @return Reader
     */
    public static function create()
    {
        return new static();
    }

    /**
     * @param string $filePath Path to the BLM file
     * @return $this
     * @throws FileNotFoundException
     * @throws InvalidBlmFileException
     */
    public function loadFromFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException();
        }

        $contents = file_get_contents($filePath);

        if (!$this->containsValidBLM($contents)) {
            throw new InvalidBlmFileException('No valid BLM file found.');
        }

        return $this->parse($contents);
    }

    /**
     * @param string $contents Contents of a BLM file
     * @return Reader
     * @throws InvalidBlmFileException
     */
    public function loadFromString($contents)
    {
        if (!$this->containsValidBLM($contents)) {
            throw new InvalidBlmStringException('Invalid BLM content found.');
        }

        return $this->parse($contents);
    }

    /**
     * @return string
     */
    public function getRawContents()
    {
        return $this->contents;
    }

    /**
     * Return array of DATA
     * @return array
     */
    public function toArray()
    {
        if (is_null($this->data)) {
            return [];
        }
        return $this->data->toArray();
    }

    /**
     * @return Collection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Collection
     */
    protected function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return Collection
     */
    protected function getDefinitions()
    {
        return $this->definitions;
    }


    /**
     * Validates a string
     * @param string $contents
     * @return bool Returns true if content is valid
     */
    protected function containsValidBLM($contents)
    {
        $contains = $this->containsHeader($contents) ? self::CONTAINS_HEADERS : 0;
        $contains += $this->containsDefinition($contents) ? self::CONTAINS_DEFINITIONS : 0;
        $contains += $this->containsData($contents) ? self::CONTAINS_DATA : 0;

        $shouldContain = self::CONTAINS_HEADERS | self::CONTAINS_DEFINITIONS | self::CONTAINS_DATA;

        return ($shouldContain & $contains);
    }

    /**
     * Verifies if contents contain a headers sections
     * @param string $contents
     * @return bool
     */
    protected function containsHeader($contents)
    {
        return $this->getRegexFor('#HEADER#')->test($contents);
    }

    /**
     * Verifies if contents contain a headers sections
     * @param string $contents
     * @return bool
     */
    protected function containsDefinition($contents)
    {
        return $this->getRegexFor('#DEFINITION#')->test($contents);
    }

    /**
     * Verifies if contents contain a headers sections
     * @param string $contents
     * @return bool
     */
    protected function containsData($contents)
    {
        return $this->getRegexFor('#DATA#')->test($contents);
    }

    /**
     * @param string $contents
     * @return Reader
     */
    protected function parse($contents)
    {
        $this->contents = $contents;

        $this->parseHeader($contents);

        $this->parseDefinition($contents);

        $this->parseData($contents);

        return $this;
    }

    /**
     * Parses the #HEADER# section of the BLM file and stores it in $this->headers
     * @param string $contents
     */
    protected function parseHeader($contents)
    {
        preg_match($this->getRegexFor('#HEADER#'), $contents, $match);

        $this->headers = collect(explode("\n", $match[0]))
            ->map(function ($linesWithSpaces) {
                return trim($linesWithSpaces);
            })
            ->reject(function ($line) {
                return '' === $line || false === strpos($line, ':');
            })->map(function ($line) {
                return explode(' : ', $line);
            })->flatMap(function ($keyValuePairWithQuotes) {
                return [
                    $keyValuePairWithQuotes[0] => preg_replace('/(^[\'"]|[\'"]$)/', '',
                        trim($keyValuePairWithQuotes[1]))
                ];
            });
    }

    /**
     * Parses the #DEFINITION# section of the BLM file and stores it in $this->definitions
     * @param string $contents
     */
    protected function parseDefinition($contents)
    {
        if (empty($this->headers)) {
            $this->parseHeader($contents);
        }

        preg_match($this->getRegexFor('#DEFINITION#'), $contents, $match);

        $eof = $this->headers->get('EOF');
        $eor = $this->headers->get('EOR');

        $this->definitions = collect(explode("\n", $match[0]))
            ->reject(function ($line) {
                return false !== strpos($line, '#') || '' === trim($line);
            })->flatMap(function ($definitions) use ($eof) {
                return explode($eof, $definitions);
            })->map(function ($definition) {
                return trim($definition);
            })->reject(function ($defintion) use ($eor) {
                return '' === $defintion || $eor === $defintion;
            });
    }

    /**
     * Parses the #DATA# section of the BLM file and stores it in $this->data
     * @param $contents
     */
    protected function parseData($contents)
    {
        if (empty($this->definitions)) {
            $this->parseDefinition($contents);
        }

        preg_match($this->getRegexFor('#DATA#'), $contents, $match);

        $eof = $this->headers->get('EOF');
        $eor = $this->headers->get('EOR');
        $definitions = $this->definitions;

        $this->data = collect(explode("\n", $match[0]))
            ->reject(function ($line) {
                return false !== strpos($line, '#') || '' === trim($line);
            })->flatMap(function ($data) use ($eor) {
                return explode($eor, $data);
            })->reject(function ($line) {
                return '' === $line;
            })->map(function ($record) {
                return trim($record);
            })->map(function ($record) use ($eof) {
                return explode($eof, $record);
            })->map(function( $record) use ($definitions) {
                return collect($record)
                    ->filter(function ($column, $offset) use ($definitions) {
                        return $definitions->offsetExists($offset);
                    })
                    ->flatMap(function ($column, $index) use ($definitions) {
                        return [$definitions[$index] => $column];
                    })->toArray();
            })->values();
    }

    /**
     * @param $string
     * @return VerbalExpressions
     */
    private function getRegexFor($string)
    {
        return (new VerbalExpressions)
            ->startOfLine()
            ->find($string)
            ->anythingBut('#')
            ->addModifier('sm');
    }

}
