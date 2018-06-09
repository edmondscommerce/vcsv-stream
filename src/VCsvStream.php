<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Rows\RowInterface;
use BenRowan\VCsvStream\Stream;

class VCsvStream
{
    /**
     * @var Stream\FileInterface
     */
    private static $file;

    /**
     * @var Stream\ConfigInterface
     */
    private static $config;

    /**
     * @var Stream\StateInterface
     */
    private static $state;

    /**
     * Initialise VCsvStream.
     *
     * @param array $config All VCsvStream configuration values.
     *
     * @throws VCsvStreamException
     */
    public static function setup(array $config = []): void
    {
        self::$file   = new Stream\File();
        self::$config = new Stream\Config($config);
        self::$state  = new Stream\State();

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
        self::$state->addHeader($header);
    }

    /**
     * @return bool Confirm a header has been set.
     */
    public static function hasHeader(): bool
    {
        return self::$state->hasHeader();
    }

    /**
     * @return RowInterface Get the current header.
     */
    public static function getHeader(): RowInterface
    {
        return self::$state->getHeader();
    }

    /**
     * @param RowInterface $record Add a record to be rendered.
     */
    public static function addRecord(RowInterface $record): void
    {
        self::$state->addRecord($record);
    }

    /**
     * @param RowInterface[] $records Add a set of records to be rendered.
     */
    public static function addRecords(array $records): void
    {
        self::$state->addRecords($records);
    }

    /**
     * @return bool Confirm one or more records have been set.
     */
    public static function hasRecords(): bool
    {
        return self::$state->hasRecords();
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
        return self::$state->currentRecord();
    }

    /**
     * Move the record pointer to the next record.
     */
    public static function nextRecord(): void
    {
        self::$state->nextRecord();
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