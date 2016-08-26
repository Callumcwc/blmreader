<?php

namespace Renedekat\Blm\Drivers;

use Renedekat\Blm\Reader;

class Csv extends Reader
{

    /**
     * Returns a resource handle residing in memory, that contains the CSV data
     * @return resource
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

        return $handle;
    }
}
