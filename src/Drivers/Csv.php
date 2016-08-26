<?php

namespace Renedekat\Blm\Drivers;

use Renedekat\Blm\Reader;

class Csv extends Reader
{

    /**
     * Returns a string with CSV data
     * @return string
     */
    public function getOutput()
    {
        $delimiter = ',';

        $handle = fopen('php://memory', 'w');

        fputcsv($handle, $this->getDefinitions()->toArray(), $delimiter);

        $this->getData()->each(function ($record) use ($handle, $delimiter) {
            fputcsv($handle, $record, $delimiter);
        });

        fseek($handle, 0);

        return $this->getCsvContentsFromHandle($handle);
    }

    /**
     * Get CSV contents from file handle
     * @param $handle
     * @return string
     */
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
