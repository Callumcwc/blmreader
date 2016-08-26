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

        $output = $csv->getOutput();

        $expectedContent = file_get_contents(dirname(__FILE__) . '/valid.csv');
        
        $this->assertEquals($expectedContent, $output);
    }
}
