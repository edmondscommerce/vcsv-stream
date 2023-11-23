<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Stream\File;
use BenRowan\VCsvStream\Stream\Config;
use BenRowan\VCsvStream\Stream\State;
use BenRowan\VCsvStream\Stream\FileInterface;
use BenRowan\VCsvStream\Stream\ConfigInterface;
use BenRowan\VCsvStream\Stream\StateInterface;
use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Rows\RowInterface;
use BenRowan\VCsvStream\Stream;

class VCsvStream
{
    private static ?File $file = null;

    private static ?Config $config = null;

    private static ?State $state = null;

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
        self::$state  = new State();

        GeneratorFactory::setup();

        VCsvStreamWrapper::setup();
    }

    /**
     * Gets the current representation of the file.
     */
    public static function getFile(): FileInterface
    {
        return self::$file;
    }

    /**
     * Gets the current configuration.
     */
    public static function getConfig(): ConfigInterface
    {
        return self::$config;
    }

    /**
     * Gets the current stream state.
     */
    public static function getState(): StateInterface
    {
        return self::$state;
    }

    /**
     * Set the header to be rendered.
     */
    public static function setHeader(RowInterface $header): void
    {
        self::$state->setHeader($header);
    }

    /**
     * Add a record to be rendered.
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