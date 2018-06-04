<?php

namespace BenRowan\VCsvStream\Test;

use BenRowan\VCsvStream\Rows\Header;
use BenRowan\VCsvStream\Rows\Record;
use BenRowan\VCsvStream\VCsvStream;
use PHPUnit\Framework\TestCase;

class VCsvStreamTest extends TestCase
{
    /**
     * Run the code...
     *
     * @test
     *
     * @throws \BenRowan\VCsvStream\Exceptions\VCsvStreamException
     */
    public function iCanGetDataFromStream(): void
    {
        VCsvStream::setup();

        $header = new Header();

        $header
            ->addValueColumn('Column One', 1)
            ->addFakerColumn('Column Two', 'randomNumber', true)
            ->addColumn('Column Three');

        vCsvStream::addHeader($header);
        VCsvStream::addRecord(new Record(10));

        $vCsv = new \SplFileObject('vcsv://fixture.csv');

        $rows = [];
        while ($row = $vCsv->fgetcsv()) {
            $rows[] = $row;
        }

        $this->assertCount(11, $rows);
    }
}
