<?php

namespace BenRowan\VCsvStream\Test;

use BenRowan\VCsvStream\VCsvStream;
use BenRowan\VCsvStream\VCsvStreamHeader;
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

        $header = new VCsvStreamHeader();

        $header
            ->addFixedValueColumn('Column One', 1)
            ->addFakerValueColumn('Column Two', 'randomNumber', true)
            ->addColumn('Column Three');

        vCsvStream::addHeader($header);

        $vCsv = new \SplFileObject('vcsv://fixture.csv');

        while ($row = $vCsv->fgetcsv()) {
            $this->assertNotNull($row);
        }
    }
}
