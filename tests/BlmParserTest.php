<?php

namespace Renedekat\Blm\Test;

use PHPUnit_Framework_TestCase;
use Renedekat\Blm\Drivers\Simple;
use Renedekat\Blm\Exceptions\InvalidBlmFileException;
use Renedekat\Blm\Exceptions\InvalidBlmStringException;

class BlmParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_instantiate_blm_reader_from_blm_file()
    {
        $blmFile = dirname(__FILE__) . '/valid.blm';

        $contents = file_get_contents($blmFile);

        $simple = Simple::create()->loadFromFile($blmFile);

        $this->assertInstanceOf(Simple::class, $simple);

        $this->assertEquals($contents, $simple->getRawContents());
    }

    /**
     * @test
     */
    public function cannot_instantiate_blm_reader_from_invalid_file()
    {
        $this->expectException(InvalidBlmFileException::class);

        Simple::create()->loadFromFile(dirname(__FILE__) . '/invalid.blm');
    }

    /**
     * @test
     */
    public function can_instantiate_blm_reader_from_valid_string()
    {
        $contents = file_get_contents(dirname(__FILE__) . '/valid.blm');

        $simple = Simple::create()->loadFromString($contents);

        $this->assertInstanceOf(Simple::class, $simple);

        $this->assertEquals($contents, $simple->getRawContents());
    }

    /**
     * @test
     */
    public function gets_simple_valid_output()
    {
        $simple = Simple::create()->loadFromFile(dirname(__FILE__) . '/valid.blm');

        $output = $simple->getOutput();

        $this->assertArrayHasKey('headers', $output);

        $this->assertArrayHasKey('definitions', $output);

        $this->assertArrayHasKey('data', $output);

        $this->assertEquals($this->getExpectedData(), $output['data']);
    }

    /**
     * @test
     */
    public function cannot_instantiate_blm_reader_from_invalid_string()
    {
        $this->expectException(InvalidBlmStringException::class);

        $blmContents = file_get_contents(dirname(__FILE__) . '/invalid.blm');

        Simple::create()->loadFromString($blmContents);
    }

    /**
     * @return array Expected data
     */
    private function getExpectedData()
    {
        return $expected = [
            [
                'AGENT_REF' => "red_MOB110555",
                'ADDRESS_1' => "44 High Street",
                'ADDRESS_2' => "Feckenham",
                'ADDRESS_3' => "",
                'ADDRESS_4' => "Worcestershire",
                'POSTCODE1' => "B96",
                'POSTCODE2' => "6HS",
                'FEATURE1' => "1 Bathroom",
                'FEATURE2' => "Cottage",
                'FEATURE3' => "Semi Detached",
                'FEATURE4' => "Garden",
                'FEATURE5' => "Utility Room",
                'FEATURE6' => "Off Street Parking",
                'FEATURE7' => "",
                'FEATURE8' => "",
                'FEATURE9' => "",
                'FEATURE10' => "",
                'SUMMARY' => "Located in the heart of the popular village of Feckenham this charming cottage has undergone significant improvement by the current owners. (contd...)",
                'DESCRIPTION' => "Located in the heart of the popular village of Feckenham this charming cottage has undergone significant improvement by the current owners.  The accommodation offers lounge with open fireplace, dining room with flagstone flooring, recently refitted kitchen, study area, cellar, three bedrooms and re-fitted bathroom.  The gardens and grounds extend to the side with a raised terrace to the rear of the property.  Unusually for Feckenham the property provides a driveway with lowered curb.<BR />",
                'BRANCH_ID' => "red",
                'STATUS_ID' => "1",
                'BEDROOMS' => "3",
                'PRICE' => "290000",
                'PRICE_QUALIFIER' => "5",
                'PROP_SUB_ID' => "3",
                'CREATE_DATE' => "2011-03-02 11:01:38",
                'UPDATE_DATE' => "2013-09-17 09:45:51",
                'DISPLAY_ADDRESS' => "High Street, Feckenham, B96",
                'PUBLISHED_FLAG' => "1",
                'LET_DATE_AVAILABLE' => "",
                'LET_TYPE_ID' => "",
                'LET_FURN_ID' => "",
                'LET_RENT_FREQUENCY' => "1",
                'TENURE_TYPE_ID' => "",
                'TRANS_TYPE_ID' => "1",
                'NEW_HOME_FLAG' => "",
                'MEDIA_IMAGE_00' => "red_MOB110555_IMG_00.JPG",
                'MEDIA_IMAGE_TEXT_00' => "Front",
                'MEDIA_IMAGE_01' => "red_MOB110555_IMG_01.JPG",
                'MEDIA_IMAGE_TEXT_01' => "Kitchen",
                'MEDIA_IMAGE_02' => "red_MOB110555_IMG_02.JPG",
                'MEDIA_IMAGE_TEXT_02' => "Dining Room",
                'MEDIA_IMAGE_03' => "red_MOB110555_IMG_03.JPG",
                'MEDIA_IMAGE_TEXT_03' => "Lounge",
                'MEDIA_IMAGE_04' => "red_MOB110555_IMG_04.JPG",
                'MEDIA_IMAGE_TEXT_04' => "Side Garden",
                'MEDIA_IMAGE_05' => "red_MOB110555_IMG_05.JPG",
                'MEDIA_IMAGE_TEXT_05' => "Terrace",
                'MEDIA_IMAGE_06' => "red_MOB110555_IMG_06.JPG",
                'MEDIA_IMAGE_TEXT_06' => "Dining Room",
                'MEDIA_IMAGE_07' => "red_MOB110555_IMG_07.JPG",
                'MEDIA_IMAGE_TEXT_07' => "Lounge",
                'MEDIA_IMAGE_08' => "red_MOB110555_IMG_08.JPG",
                'MEDIA_IMAGE_TEXT_08' => "Bedroom",
                'MEDIA_IMAGE_09' => "red_MOB110555_IMG_09.JPG",
                'MEDIA_IMAGE_TEXT_09' => "Bathroom",
                'MEDIA_IMAGE_10' => "",
                'MEDIA_IMAGE_TEXT_10' => "",
                'MEDIA_IMAGE_11' => "",
                'MEDIA_IMAGE_TEXT_11' => "",
                'MEDIA_IMAGE_12' => "",
                'MEDIA_IMAGE_TEXT_12' => "",
                'MEDIA_IMAGE_13' => "",
                'MEDIA_IMAGE_TEXT_13' => "",
                'MEDIA_IMAGE_14' => "",
                'MEDIA_IMAGE_TEXT_14' => "",
                'MEDIA_IMAGE_15' => "",
                'MEDIA_IMAGE_TEXT_15' => "",
                'MEDIA_IMAGE_16' => "",
                'MEDIA_IMAGE_TEXT_16' => "",
                'MEDIA_IMAGE_17' => "",
                'MEDIA_IMAGE_TEXT_17' => "",
                'MEDIA_IMAGE_18' => "",
                'MEDIA_IMAGE_TEXT_18' => "",
                'MEDIA_IMAGE_19' => "",
                'MEDIA_IMAGE_TEXT_19' => "",
                'MEDIA_IMAGE_60' => "red_MOB110555_IMG_60.png",
                'MEDIA_IMAGE_TEXT_60' => "EPC",
                'MEDIA_FLOOR_PLAN_00' => "red_MOB110555_FLP_00.GIF",
                'MEDIA_FLOOR_PLAN_TEXT_00' => "Floorplan",
                'MEDIA_FLOOR_PLAN_01' => "",
                'MEDIA_FLOOR_PLAN_TEXT_01' => "",
                'MEDIA_FLOOR_PLAN_02' => "",
                'MEDIA_FLOOR_PLAN_TEXT_02' => "",
                'MEDIA_FLOOR_PLAN_03' => "",
                'MEDIA_FLOOR_PLAN_TEXT_03' => "",
                'MEDIA_DOCUMENT_00' => "http://abc.reapitcloud.com/hadrps/public/details/MOB11/prp/MOB110002_RED13003423.PDF",
                'MEDIA_DOCUMENT_TEXT_00' => "Particulars",
                'MEDIA_DOCUMENT_50' => "",
                'MEDIA_DOCUMENT_TEXT_50' => "",
                'MEDIA_DOCUMENT_51' => "",
                'MEDIA_DOCUMENT_TEXT_51' => "",
                'MEDIA_VIRTUAL_TOUR_00' => "",
                'MEDIA_VIRTUAL_TOUR_TEXT_00' => "",
                'MEDIA_VIRTUAL_TOUR_01' => "",
                'MEDIA_VIRTUAL_TOUR_TEXT_01' => "",
            ], [
                'AGENT_REF' => "red_MOB110666",
                'ADDRESS_1' => "Burch Lane",
                'ADDRESS_2' => "Cookhill",
                'ADDRESS_3' => "Alcester",
                'ADDRESS_4' => "",
                'POSTCODE1' => "B49",
                'POSTCODE2' => "5JS",
                'FEATURE1' => "3 Bathrooms",
                'FEATURE2' => "House",
                'FEATURE3' => "Detached",
                'FEATURE4' => "Garden",
                'FEATURE5' => "Conservatory",
                'FEATURE6' => "Downstairs W/C",
                'FEATURE7' => "Utility Room",
                'FEATURE8' => "Double Garage",
                'FEATURE9' => "Freehold",
                'FEATURE10' => "",
                'SUMMARY' => "A significant five bedroom detached family residence standing within a 0.25 acre plot (approx) opposite the beautiful St Paul's Parish Burch behind a mature evergreen border and substantial private mature rear gardens to the rear. (contd...)",
                'DESCRIPTION' => "A significant five bedroom detached family residence standing within a 0.25 acre plot (approx) opposite the beautiful St Paul's Parish Burch behind a mature evergreen border and substantial private mature rear gardens to the rear. Internally the property boasts four reception rooms including conservatory, study, breakfast kitchen, utility, four double bedrooms, master with generous en-suite bathroom, further single bedroom, two further bathrooms. Driveway provides parking for multiple vehicles",
                'BRANCH_ID' => "red",
                'STATUS_ID' => "0",
                'BEDROOMS' => "5",
                'PRICE' => "500000",
                'PRICE_QUALIFIER' => "2",
                'PROP_SUB_ID' => "4",
                'CREATE_DATE' => "2012-03-19 12:58:12",
                'UPDATE_DATE' => "2013-08-22 13:58:07",
                'DISPLAY_ADDRESS' => "Burch Lane, Cookhill, B49",
                'PUBLISHED_FLAG' => "1",
                'LET_DATE_AVAILABLE' => "",
                'LET_TYPE_ID' => "",
                'LET_FURN_ID' => "",
                'LET_RENT_FREQUENCY' => "1",
                'TENURE_TYPE_ID' => "1",
                'TRANS_TYPE_ID' => "1",
                'NEW_HOME_FLAG' => "",
                'MEDIA_IMAGE_00' => "red_MOB110666_IMG_00.JPG",
                'MEDIA_IMAGE_TEXT_00' => "Front",
                'MEDIA_IMAGE_01' => "red_MOB110666_IMG_01.JPG",
                'MEDIA_IMAGE_TEXT_01' => "Garden 1",
                'MEDIA_IMAGE_02' => "red_MOB110666_IMG_02.JPG",
                'MEDIA_IMAGE_TEXT_02' => "Burch",
                'MEDIA_IMAGE_03' => "red_MOB110666_IMG_03.JPG",
                'MEDIA_IMAGE_TEXT_03' => "Garden 2",
                'MEDIA_IMAGE_04' => "red_MOB110666_IMG_04.JPG",
                'MEDIA_IMAGE_TEXT_04' => "Kitchen",
                'MEDIA_IMAGE_05' => "red_MOB110666_IMG_05.JPG",
                'MEDIA_IMAGE_TEXT_05' => "Lounge",
                'MEDIA_IMAGE_06' => "red_MOB110666_IMG_06.JPG",
                'MEDIA_IMAGE_TEXT_06' => "Family Room",
                'MEDIA_IMAGE_07' => "red_MOB110666_IMG_07.JPG",
                'MEDIA_IMAGE_TEXT_07' => "En-Suite",
                'MEDIA_IMAGE_08' => "red_MOB110666_IMG_08.JPG",
                'MEDIA_IMAGE_TEXT_08' => "Conservatory",
                'MEDIA_IMAGE_09' => "",
                'MEDIA_IMAGE_TEXT_09' => "",
                'MEDIA_IMAGE_10' => "",
                'MEDIA_IMAGE_TEXT_10' => "",
                'MEDIA_IMAGE_11' => "",
                'MEDIA_IMAGE_TEXT_11' => "",
                'MEDIA_IMAGE_12' => "",
                'MEDIA_IMAGE_TEXT_12' => "",
                'MEDIA_IMAGE_13' => "",
                'MEDIA_IMAGE_TEXT_13' => "",
                'MEDIA_IMAGE_14' => "",
                'MEDIA_IMAGE_TEXT_14' => "",
                'MEDIA_IMAGE_15' => "",
                'MEDIA_IMAGE_TEXT_15' => "",
                'MEDIA_IMAGE_16' => "",
                'MEDIA_IMAGE_TEXT_16' => "",
                'MEDIA_IMAGE_17' => "",
                'MEDIA_IMAGE_TEXT_17' => "",
                'MEDIA_IMAGE_18' => "",
                'MEDIA_IMAGE_TEXT_18' => "",
                'MEDIA_IMAGE_19' => "",
                'MEDIA_IMAGE_TEXT_19' => "",
                'MEDIA_IMAGE_60' => "red_MOB110666_IMG_60.png",
                'MEDIA_IMAGE_TEXT_60' => "EPC",
                'MEDIA_FLOOR_PLAN_00' => "red_MOB110666_FLP_00.JPG",
                'MEDIA_FLOOR_PLAN_TEXT_00' => "Floorplan",
                'MEDIA_FLOOR_PLAN_01' => "red_MOB110666_FLP_01.JPG",
                'MEDIA_FLOOR_PLAN_TEXT_01' => "Floorplan",
                'MEDIA_FLOOR_PLAN_02' => "",
                'MEDIA_FLOOR_PLAN_TEXT_02' => "",
                'MEDIA_FLOOR_PLAN_03' => "",
                'MEDIA_FLOOR_PLAN_TEXT_03' => "",
                'MEDIA_DOCUMENT_00' => "http://abc.reapitcloud.com/hadrps/public/details/MOB12/prp/MOB120010_RED13003460.PDF",
                'MEDIA_DOCUMENT_TEXT_00' => "Particulars",
                'MEDIA_DOCUMENT_50' => "",
                'MEDIA_DOCUMENT_TEXT_50' => "",
                'MEDIA_DOCUMENT_51' => "",
                'MEDIA_DOCUMENT_TEXT_51' => "",
                'MEDIA_VIRTUAL_TOUR_00' => "",
                'MEDIA_VIRTUAL_TOUR_TEXT_00' => "",
                'MEDIA_VIRTUAL_TOUR_01' => "",
                'MEDIA_VIRTUAL_TOUR_TEXT_01' => "",
            ], [
                'AGENT_REF' => "red_MOB110777",
                'ADDRESS_1' => "54 Bilbury Close",
                'ADDRESS_2' => "Redditch",
                'ADDRESS_3' => "Worcestershire",
                'ADDRESS_4' => "",
                'POSTCODE1' => "B97",
                'POSTCODE2' => "5XN",
                'FEATURE1' => "1 Bathroom",
                'FEATURE2' => "House",
                'FEATURE3' => "Terraced",
                'FEATURE4' => "Garden",
                'FEATURE5' => "Off Street Parking",
                'FEATURE6' => "Freehold",
                'FEATURE7' => "",
                'FEATURE8' => "",
                'FEATURE9' => "",
                'FEATURE10' => "",
                'SUMMARY' => "A well-presented mid terrace property with off road parking and rear garden with gated access.  The internal accommodation comprises entrance hall, lounge, kitchen, two bedrooms and bathroom.",
                'DESCRIPTION' => "A well-presented mid terrace property with off road parking and rear garden with gated access.  The internal accommodation comprises entrance hall, lounge, kitchen, two bedrooms and bathroom.<BR />",
                'BRANCH_ID' => "red",
                'STATUS_ID' => "0",
                'BEDROOMS' => "2",
                'PRICE' => "135000",
                'PRICE_QUALIFIER' => "2",
                'PROP_SUB_ID' => "1",
                'CREATE_DATE' => "2010-05-07 14:29:53",
                'UPDATE_DATE' => "2013-11-21 12:02:36",
                'DISPLAY_ADDRESS' => "Bilbury Close, Redditch, B97",
                'PUBLISHED_FLAG' => "1",
                'LET_DATE_AVAILABLE' => "",
                'LET_TYPE_ID' => "",
                'LET_FURN_ID' => "",
                'LET_RENT_FREQUENCY' => "1",
                'TENURE_TYPE_ID' => "1",
                'TRANS_TYPE_ID' => "1",
                'NEW_HOME_FLAG' => "",
                'MEDIA_IMAGE_00' => "red_MOB110777_IMG_00.JPG",
                'MEDIA_IMAGE_TEXT_00' => "Front",
                'MEDIA_IMAGE_01' => "red_MOB110777_IMG_01.JPG",
                'MEDIA_IMAGE_TEXT_01' => "Lounge",
                'MEDIA_IMAGE_02' => "red_MOB110777_IMG_02.JPG",
                'MEDIA_IMAGE_TEXT_02' => "Kitchen-Diner",
                'MEDIA_IMAGE_03' => "red_MOB110777_IMG_03.JPG",
                'MEDIA_IMAGE_TEXT_03' => "Rear Garden",
                'MEDIA_IMAGE_04' => "red_MOB110777_IMG_04.JPG",
                'MEDIA_IMAGE_TEXT_04' => "Bedroom One",
                'MEDIA_IMAGE_05' => "red_MOB110777_IMG_05.JPG",
                'MEDIA_IMAGE_TEXT_05' => "Bedroom Two",
                'MEDIA_IMAGE_06' => "red_MOB110777_IMG_06.JPG",
                'MEDIA_IMAGE_TEXT_06' => "Bathroom",
                'MEDIA_IMAGE_07' => "red_MOB110777_IMG_07.JPG",
                'MEDIA_IMAGE_TEXT_07' => "Lounge",
                'MEDIA_IMAGE_08' => "red_MOB110777_IMG_08.JPG",
                'MEDIA_IMAGE_TEXT_08' => "Kitchen",
                'MEDIA_IMAGE_09' => "red_MOB110777_IMG_09.JPG",
                'MEDIA_IMAGE_TEXT_09' => "Rear Elevation",
                'MEDIA_IMAGE_10' => "",
                'MEDIA_IMAGE_TEXT_10' => "",
                'MEDIA_IMAGE_11' => "",
                'MEDIA_IMAGE_TEXT_11' => "",
                'MEDIA_IMAGE_12' => "",
                'MEDIA_IMAGE_TEXT_12' => "",
                'MEDIA_IMAGE_13' => "",
                'MEDIA_IMAGE_TEXT_13' => "",
                'MEDIA_IMAGE_14' => "",
                'MEDIA_IMAGE_TEXT_14' => "",
                'MEDIA_IMAGE_15' => "",
                'MEDIA_IMAGE_TEXT_15' => "",
                'MEDIA_IMAGE_16' => "",
                'MEDIA_IMAGE_TEXT_16' => "",
                'MEDIA_IMAGE_17' => "",
                'MEDIA_IMAGE_TEXT_17' => "",
                'MEDIA_IMAGE_18' => "",
                'MEDIA_IMAGE_TEXT_18' => "",
                'MEDIA_IMAGE_19' => "",
                'MEDIA_IMAGE_TEXT_19' => "",
                'MEDIA_IMAGE_60' => "red_MOB110777_IMG_60.PNG",
                'MEDIA_IMAGE_TEXT_60' => "EPC",
                'MEDIA_FLOOR_PLAN_00' => "red_MOB110777_FLP_00.JPG",
                'MEDIA_FLOOR_PLAN_TEXT_00' => "Floorplan",
                'MEDIA_FLOOR_PLAN_01' => "",
                'MEDIA_FLOOR_PLAN_TEXT_01' => "",
                'MEDIA_FLOOR_PLAN_02' => "",
                'MEDIA_FLOOR_PLAN_TEXT_02' => "",
                'MEDIA_FLOOR_PLAN_03' => "",
                'MEDIA_FLOOR_PLAN_TEXT_03' => "",
                'MEDIA_DOCUMENT_00' => "http://abc.reapitcloud.com/hadrps/public/details/RED10/prp/RED100142_RED13003796.PDF",
                'MEDIA_DOCUMENT_TEXT_00' => "Particulars",
                'MEDIA_DOCUMENT_50' => "",
                'MEDIA_DOCUMENT_TEXT_50' => "",
                'MEDIA_DOCUMENT_51' => "",
                'MEDIA_DOCUMENT_TEXT_51' => "",
                'MEDIA_VIRTUAL_TOUR_00' => "",
                'MEDIA_VIRTUAL_TOUR_TEXT_00' => "",
                'MEDIA_VIRTUAL_TOUR_01' => "",
                'MEDIA_VIRTUAL_TOUR_TEXT_01' => "",
            ]
        ];
    }
}
