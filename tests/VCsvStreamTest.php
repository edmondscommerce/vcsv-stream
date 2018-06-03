<?php

namespace BenRowan\VCsvStream\Test;

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

        $vCsv = new \SplFileObject('vcsv://fixture.csv');

        while ($row = $vCsv->fgetcsv()) {
            $this->assertNotNull($row);
        }
    }
}
