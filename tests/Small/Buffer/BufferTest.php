<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Buffer;

use BenRowan\VCsvStream\Buffer\Buffer;
use BenRowan\VCsvStream\Buffer\BufferInterface;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class BufferTest extends AbstractTestCase
{
    private const FIXTURE_EMPTY_CONTENT = '';
    private const FIXTURE_CONTENT       = 'Some Content';

    /**
     * @var BufferInterface
     */
    private $buffer;

    public function setUp()
    {
        $this->buffer = new Buffer();
    }

    /**
     * @test
     */
    public function iGetTheCorrectBufferSizeInBytes(): void
    {
        $expectedBefore = \strlen(self::FIXTURE_EMPTY_CONTENT);
        $actualBefore   = $this->buffer->currentSizeInBytes();

        $this->assertSame($expectedBefore, $actualBefore);

        $this->buffer->add(self::FIXTURE_CONTENT);

        $expectedAfter = \strlen(self::FIXTURE_CONTENT);
        $actualAfter   = $this->buffer->currentSizeInBytes();

        $this->assertSame($expectedAfter, $actualAfter);
    }

    /**
     * @test
     */
    public function iCanAddContentToTheBuffer(): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->buffer, 'buffer');

        $expectedBefore = self::FIXTURE_EMPTY_CONTENT;
        $actualBefore   = $refProp->getValue($this->buffer);

        $this->assertSame($expectedBefore, $actualBefore);

        $this->buffer->add(self::FIXTURE_CONTENT);

        $expectedAfter = self::FIXTURE_CONTENT;
        $actualAfter   = $refProp->getValue($this->buffer);

        $this->assertSame($expectedAfter, $actualAfter);
    }

    /**
     * @test
     */
    public function iCanReadContentFromTheBuffer(): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->buffer, 'buffer');

        $refProp->setValue($this->buffer, self::FIXTURE_CONTENT);

        $expected = self::FIXTURE_CONTENT;
        $actual   = $this->buffer->read(\strlen(self::FIXTURE_CONTENT));

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iCanSafelyTryToReadMoreThanTheAvailableBytes(): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->buffer, 'buffer');

        $refProp->setValue($this->buffer, self::FIXTURE_CONTENT);

        $bytesToRead = \strlen(self::FIXTURE_CONTENT) * 2;

        $expected = self::FIXTURE_CONTENT;
        $actual   = $this->buffer->read($bytesToRead);

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     *
     * @param int $bytesToClean The number of bytes to be cleaned from the buffer.
     * @param string $expectedBuffer The expected buffer state after the clean.
     *
     * @dataProvider iCanCleanTheBufferDataProvider
     */
    public function iCanCleanTheBuffer(int $bytesToClean, string $expectedBuffer): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->buffer, 'buffer');

        $refProp->setValue($this->buffer, self::FIXTURE_CONTENT);

        $expectedBefore = \strlen(self::FIXTURE_CONTENT);
        $actualBefore   = $this->buffer->currentSizeInBytes();

        $this->assertSame($expectedBefore, $actualBefore);

        $this->buffer->clean($bytesToClean);

        $expectedAfter = \strlen($expectedBuffer);
        $actualAfter   = $this->buffer->currentSizeInBytes();

        $this->assertSame($expectedAfter, $actualAfter);
    }

    public function iCanCleanTheBufferDataProvider(): array
    {
        return [
            'clean_bytes_less_than_buffer_bytes' => [
                2,
                \substr(self::FIXTURE_CONTENT, 2)
            ],
            'clean_bytes_greater_than_buffer_bytes' => [
                100,
                ''
            ]
        ];
    }
}