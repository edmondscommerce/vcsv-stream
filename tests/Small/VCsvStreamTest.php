<?php

namespace BenRowan\VCsvStream\Tests\Small;

use BenRowan\VCsvStream\Rows\Header;
use BenRowan\VCsvStream\Rows\NoHeader;
use BenRowan\VCsvStream\Rows\Record;
use BenRowan\VCsvStream\VCsvStream;
use PHPUnit\Framework\TestCase;

class VCsvStreamTest extends TestCase
{
    public const HEADER_1 = 'Column One';
    public const HEADER_2 = 'Column Two';
    public const HEADER_3 = 'Coulumn Three';

    /**
     * @throws \BenRowan\VCsvStream\Exceptions\VCsvStreamException
     */
    private function setupWithHeader(): void
    {
        VCsvStream::setup();

        $header = new Header();

        $header
            ->addValueColumn(self::HEADER_1, 1)
            ->addFakerColumn(self::HEADER_2, 'randomNumber', true)
            ->addColumn(self::HEADER_3);

        VCsvStream::setHeader($header);
    }

    /**
     * @throws \BenRowan\VCsvStream\Exceptions\VCsvStreamException
     */
    private function setupWithNoHeader(): void
    {
        VCsvStream::setup();

        $header = new NoHeader();

        $header
            ->addValueColumn(self::HEADER_1, 1)
            ->addFakerColumn(self::HEADER_2, 'randomNumber', true)
            ->addColumn(self::HEADER_3);

        VCsvStream::setHeader($header);
    }

    /**
     * Run the code...
     *
     * @test
     * @throws \BenRowan\VCsvStream\Exceptions\VCsvStreamException
     */
    public function iCanGetDataFromStream(): void
    {
        $this->setupWithHeader();

        $records = [];

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 2)
            ->addFakerColumn(self::HEADER_3, 'randomNumber', false);

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 3)
            ->addFakerColumn(self::HEADER_3, 'text', false);

        $records[] = (new Record(10000))
            ->addValueColumn(self::HEADER_2, 4)
            ->addFakerColumn(self::HEADER_3, 'ipv4', false);

        VCsvStream::addRecords($records);

        $vCsv = new \SplFileObject('vcsv://fixture.csv');

        $rows = [];
        while ($row = $vCsv->fgetcsv()) {
            $rows[] = $row;
        }

        $this->assertCount(10021, $rows);
    }

    /**
     * Run the code...
     *
     * @test
     * @throws \BenRowan\VCsvStream\Exceptions\VCsvStreamException
     */
    public function iCanGetDataFromStreamWithNoHeader(): void
    {
        $this->setupWithNoHeader();

        $records = [];

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 2)
            ->addFakerColumn(self::HEADER_3, 'randomNumber', false);

        $records[] = (new Record(10))
            ->addValueColumn(self::HEADER_2, 3)
            ->addFakerColumn(self::HEADER_3, 'text', false);

        $records[] = (new Record(10000))
            ->addValueColumn(self::HEADER_2, 4)
            ->addFakerColumn(self::HEADER_3, 'ipv4', false);

        VCsvStream::addRecords($records);

        $vCsv = new \SplFileObject('vcsv://fixture.csv');

        $rows = [];
        while ($row = $vCsv->fgetcsv()) {
            $rows[] = $row;
        }

        $this->assertCount(10020, $rows);
    }
}
