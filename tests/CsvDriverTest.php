<?php

namespace Renedekat\Blm\Test;

use PHPUnit_Framework_TestCase;
use Renedekat\Blm\Drivers\Csv;

class CsvDriverTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_instantiate_blm_reader_from_blm_file()
    {
        $csv = Csv::create()->loadFromFile(dirname(__FILE__) . '/valid.blm');

        $handle = $csv->getOutput();

        $this->assertTrue(is_resource($handle));

        $expectedContent = file_get_contents(dirname(__FILE__) . '/valid.csv');

        $actualContent = $this->getCsvContentsFromHandle($handle);

        $this->assertEquals($expectedContent, $actualContent);
    }

    private function getCsvContentsFromHandle($handle)
    {
        ob_start();
        while (($line = fgets($handle)) !== false) {
            echo $line;
        }
        $actualContents = ob_get_contents();
        ob_end_clean();

        return $actualContents;
    }
}
