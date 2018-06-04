<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

class VCsvStream
{
    private const USER_ROOT = 0;

    private const GROUP_ROOT = 0;

    private const MODE = 0666;

    private static $startTime;

    private static $header;

    /**
     * Initialise VCsvStream.
     *
     * @throws Exceptions\VCsvStreamException
     */
    public static function setup(): void
    {
        self::$startTime = time();

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
            'mode'    => self::MODE,
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

    public static function addHeader(VCsvStreamHeader $header)
    {
        self::$header = $header;
    }
}