<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Stream;

use PHPUnit\Framework\Attributes\Test;
use BenRowan\VCsvStream\Stream\File;
use BenRowan\VCsvStream\Stream\FileInterface;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class FileTest extends AbstractTestCase
{
    /**
     * @var FileInterface
     */
    private File $file;

    public function setUp(): void
    {
        $this->file = new File();
    }

    #[Test]
    public function iGetMyUid(): void
    {
        if (! \function_exists('posix_getuid')) {
            $this->markTestSkipped('Function posix_getuid does not exist.');
        }

        $expected = posix_getuid();
        $actual   = $this->file->stat()['uid'];

        $this->assertSame($expected, $actual);
    }

    #[Test]
    public function iGetMyGid(): void
    {
        if (! \function_exists('posix_getgid')) {
            $this->markTestSkipped('Function posix_getgid does not exist.');
        }

        $expected = posix_getgid();
        $actual   = $this->file->stat()['gid'];

        $this->assertSame($expected, $actual);
    }

    #[Test]
    public function iGetRootUid(): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->file, 'uidFuncExists');

        $refProp->setValue($this->file, false);

        $expected = 0;
        $actual   = $this->file->stat()['uid'];

        $this->assertSame($expected, $actual);
    }

    #[Test]
    public function iGetRootGid(): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->file, 'gidFuncExists');

        $refProp->setValue($this->file, false);

        $expected = 0;
        $actual   = $this->file->stat()['gid'];

        $this->assertSame($expected, $actual);
    }
}