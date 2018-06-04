<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Rows\RowInterface;

class VCsvStream
{
    private const USER_ROOT = 0;

    private const GROUP_ROOT = 0;

    private const DEFAULT_MODE = 0666;

    private const DEFAULT_DELIMITER = ',';

    private const DEFAULT_ENCLOSURE = '"';

    private const DEFAULT_NEWLINE = "\n";

    private static $startTime;

    private static $header;

    private static $currentRecord;

    private static $records = [];

    /**
     * Initialise VCsvStream.
     *
     * @throws Exceptions\VCsvStreamException
     */
    public static function setup(): void
    {
        self::$startTime     = time();
        self::$header        = null;
        self::$currentRecord = 0;
        self::$records       = [];

        GeneratorFactory::setup();

        VCsvStreamWrapper::register();
    }

    private static function getUid(): int
    {
        return \function_exists('posix_getuid') ? posix_getuid() : self::USER_ROOT;
    }

    private static function getGid(): int
    {
        return \function_exists('posix_getgid') ? posix_getgid() : self::GROUP_ROOT;
    }

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

    public static function addHeader(RowInterface $header): void
    {
        self::$header = $header;
    }

    public static function hasHeader(): bool
    {
        return null !== self::$header;
    }

    public static function getHeader(): RowInterface
    {
        return self::$header;
    }

    /**
     * @param RowInterface $record
     */
    public static function addRecord(RowInterface $record): void
    {
        self::$records[] = $record;
    }

    /**
     * @param RowInterface[] $records
     */
    public static function addRecords(array $records): void
    {
        foreach ($records as $record) {
            self::addRecord($record);
        }
    }

    public static function hasRecords(): bool
    {
        return \count(self::$records) !== self::$currentRecord;
    }

    /**
     * @return RowInterface
     * @throws VCsvStreamException
     */
    public static function currentRecord(): RowInterface
    {
        if (! self::hasRecords()) {
            throw new VCsvStreamException('No record available.');
        }

        return self::$records[self::$currentRecord];
    }

    public static function nextRecord(): void
    {
        self::$currentRecord++;
    }

    public static function getDelimiter(): string
    {
        return self::DEFAULT_DELIMITER;
    }

    public static function getEnclosure(): string
    {
        return self::DEFAULT_ENCLOSURE;
    }

    public static function getNewline(): string
    {
        return self::DEFAULT_NEWLINE;
    }
}