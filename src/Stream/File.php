<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

class File implements FileInterface
{
    private const FILE_USER_ROOT  = 0;

    private const FILE_GROUP_ROOT = 0;

    private const FILE_MODE       = 0666;

    private $time;

    public function __construct()
    {
        $this->time = time();
    }

    /**
     * Get's the current processes UID if possible. Returns 0 (root) if not.
     *
     * @return int
     */
    private function getUid(): int
    {
        return \function_exists('posix_getuid') ? posix_getuid() : self::FILE_USER_ROOT;
    }

    /**
     * Get's the current processes GID if possible. Returns 0 (root) if not.
     *
     * @return int
     */
    private function getGid(): int
    {
        return \function_exists('posix_getgid') ? posix_getgid() : self::FILE_GROUP_ROOT;
    }

    /**
     * Returns some fake stats for the CSV file.
     *
     * @return array
     */
    public function stat(): array
    {
        $stat = [
            'dev'     => 0,
            'ino'     => 0,
            'mode'    => self::FILE_MODE,
            'nlink'   => 0,
            'uid'     => $this->getUid(),
            'gid'     => $this->getGid(),
            'rdev'    => 0,
            'size'    => 0,
            'atime'   => $this->time,
            'mtime'   => $this->time,
            'ctime'   => $this->time,
            'blksize' => -1,
            'blocks'  => -1
        ];

        return array_merge(
            array_values($stat),
            $stat
        );
    }
}