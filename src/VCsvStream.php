<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Rows\RowInterface;
use BenRowan\VCsvStream\Stream\Config;
use BenRowan\VCsvStream\Stream\ConfigInterface;
use BenRowan\VCsvStream\Stream\File;
use BenRowan\VCsvStream\Stream\FileInterface;

class VCsvStream
{
    /**
     * @var RowInterface The header to be used for the CSV file.
     */
    private static $header;

    /**
     * @var RowInterface[] All records to be added to the CSV file.
     */
    private static $records = [];

    /**
     * @var int Pointer to the current record to be rendered.
     */
    private static $currentRecord;

    /**
     * @var FileInterface
     */
    private static $file;

    /**
     * @var ConfigInterface
     */
    private static $config;

    /**
     * Initialise VCsvStream.
     *
     * @param array $config All VCsvStream configuration values.
     *
     * @throws VCsvStreamException
     */
    public static function setup(array $config = []): void
    {
        self::$file   = new File();
        self::$config = new Config($config);

        self::$header        = null;
        self::$currentRecord = 0;
        self::$records       = [];

        GeneratorFactory::setup();

        VCsvStreamWrapper::register();
    }

    /**
     * @return array Returns some fake stats for the CSV file.
     */
    public static function stat(): array
    {
        return self::$file->stat();
    }

    /**
     * @param RowInterface $header Add a header to be rendered.
     */
    public static function addHeader(RowInterface $header): void
    {
        self::$header = $header;
    }

    /**
     * @return bool Confirm a header has been set.
     */
    public static function hasHeader(): bool
    {
        return null !== self::$header;
    }

    /**
     * @return RowInterface Get the current header.
     */
    public static function getHeader(): RowInterface
    {
        return self::$header;
    }

    /**
     * @param RowInterface $record Add a record to be rendered.
     */
    public static function addRecord(RowInterface $record): void
    {
        self::$records[] = $record;
    }

    /**
     * @param RowInterface[] $records Add a set of records to be rendered.
     */
    public static function addRecords(array $records): void
    {
        foreach ($records as $record) {
            self::addRecord($record);
        }
    }

    /**
     * @return bool Confirm one or more records have been set.
     */
    public static function hasRecords(): bool
    {
        return \count(self::$records) !== self::$currentRecord;
    }

    /**
     * Get the current record.
     *
     * @return RowInterface
     *
     * @throws VCsvStreamException
     */
    public static function currentRecord(): RowInterface
    {
        if (! self::hasRecords()) {
            throw new VCsvStreamException('No record available.');
        }

        return self::$records[self::$currentRecord];
    }

    /**
     * Move the record pointer to the next record.
     */
    public static function nextRecord(): void
    {
        self::$currentRecord++;
    }

    /**
     * @return string Get the currently configured delimiter character.
     */
    public static function getDelimiter(): string
    {
        return self::$config->getDelimiter();
    }

    /**
     * @return string Get the currently configured enclosure character.
     */
    public static function getEnclosure(): string
    {
        return self::$config->getEnclosure();
    }

    /**
     * @return string Get the currently configured newline character.
     */
    public static function getNewline(): string
    {
        return self::$config->getNewline();
    }
}