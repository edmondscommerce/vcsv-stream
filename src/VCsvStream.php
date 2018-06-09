<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Rows\RowInterface;
use BenRowan\VCsvStream\Stream\File;

class VCsvStream
{
    /**
     * Constants used as configuration keys.
     */

    public const CONFIG_DELIMITER = 'delimiter';

    public const CONFIG_ENCLOSURE = 'enclosure';

    public const CONFIG_NEWLINE = 'newline';

    /**
     * Default configuration values.
     */

    private const DEFAULT_DELIMITER = ',';

    private const DEFAULT_ENCLOSURE = '"';

    private const DEFAULT_NEWLINE = "\n";

    /**
     * @var array All VCsvStream configuration values.
     */
    private static $config = [];

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
     * @var File
     */
    private static $file;

    /**
     * Initialise VCsvStream.
     *
     * @param array $config All VCsvStream configuration values.
     *
     * @throws VCsvStreamException
     */
    public static function setup(array $config = []): void
    {
        self::$file = new File();

        self::$config        = $config;
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
        if (isset(self::$config[self::CONFIG_DELIMITER])) {
            return self::$config[self::CONFIG_DELIMITER];
        }

        return self::DEFAULT_DELIMITER;
    }

    /**
     * @return string Get the currently configured enclosure character.
     */
    public static function getEnclosure(): string
    {
        if (isset(self::$config[self::CONFIG_ENCLOSURE])) {
            return self::$config[self::CONFIG_ENCLOSURE];
        }

        return self::DEFAULT_ENCLOSURE;
    }

    /**
     * @return string Get the currently configured newline character.
     */
    public static function getNewline(): string
    {
        if (isset(self::$config[self::CONFIG_NEWLINE])) {
            return self::$config[self::CONFIG_NEWLINE];
        }

        return self::DEFAULT_NEWLINE;
    }
}