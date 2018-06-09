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

        VCsvStreamWrapper::setup();
    }

    /**
     * Gets the current representation of the file.
     *
     * @return Stream\FileInterface
     */
    public static function getFile(): Stream\FileInterface
    {
        return self::$file;
    }

    /**
     * Gets the current configuration.
     *
     * @return Stream\ConfigInterface
     */
    public static function getConfig(): Stream\ConfigInterface
    {
        return self::$config;
    }

    /**
     * Gets the current stream state.
     *
     * @return Stream\StateInterface
     */
    public static function getState(): Stream\StateInterface
    {
        return self::$state;
    }

    /**
     * Set the header to be rendered.
     *
     * @param RowInterface $header
     */
    public static function setHeader(RowInterface $header): void
    {
        self::$state->setHeader($header);
    }

    /**
     * Add a record to be rendered.
     *
     * @param RowInterface $record
     */
    public static function addRecord(RowInterface $record): void
    {
        self::$state->addRecord($record);
    }

    /**
     * Add a set of records to be rendered.
     *
     * @param RowInterface[] $records
     */
    public static function addRecords(array $records): void
    {
        self::$state->addRecords($records);
    }
}