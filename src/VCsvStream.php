<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Rows\RowInterface;

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

    private const USER_ROOT = 0;

    private const GROUP_ROOT = 0;

    private const DEFAULT_MODE = 0666;

    private const DEFAULT_DELIMITER = ',';

    private const DEFAULT_ENCLOSURE = '"';

    private const DEFAULT_NEWLINE = "\n";

    /**
     * @var array All VCsvStream configuration values.
     */
    private static $config = [];

    /**
     * @var int Used to provide the CSV files atime, mtime and ctime.
     */
    private static $startTime;

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
     * Initialise VCsvStream.
     *
     * @param array $config All VCsvStream configuration values.
     *
     * @throws VCsvStreamException
     */
    public static function setup(array $config = []): void
    {
        self::$config        = $config;
        self::$startTime     = time();
        self::$header        = null;
        self::$currentRecord = 0;
        self::$records       = [];

        GeneratorFactory::setup();

        VCsvStreamWrapper::register();
    }

    /**
     * @return int Get's the current processes UID if possible. Returns 0 (root) if not.
     */
    private static function getUid(): int
    {
        return \function_exists('posix_getuid') ? posix_getuid() : self::USER_ROOT;
    }

    /**
     * @return int Get's the current processes GID if possible. Returns 0 (root) if not.
     */
    private static function getGid(): int
    {
        return \function_exists('posix_getgid') ? posix_getgid() : self::GROUP_ROOT;
    }

    /**
     * @return array Returns some fake stats for the CSV file.
     */
    public static function stat(): array
    {
        $stat = [
            'dev'     => 0,
            'ino'     => 0,
            'mode'    => self::DEFAULT_MODE,
            'nlink'   => 0,
            'uid'     => self::getUid(),
            'gid'     => self::getGid(),
            'rdev'    => 0,
            'size'    => 0,
            'atime'   => self::$startTime,
            'mtime'   => self::$startTime,
            'ctime'   => self::$startTime,
            'blksize' => -1,
            'blocks'  => -1
        ];

        return array_merge(
            array_values($stat),
            $stat
        );
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