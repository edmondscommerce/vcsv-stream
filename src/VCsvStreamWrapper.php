<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Buffer\Buffer;
use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Renderer\Renderer;
use BenRowan\VCsvStream\Stream\Manager;

class VCsvStreamWrapper
{
    private $buffer;

    private $renderer;

    public function __construct()
    {
        $this->buffer   = new Buffer();
        $this->renderer = new Renderer();
    }

    /**
     * Register this stream wrapper for the vcsv protocol.
     *
     * @throws VCsvStreamException
     */
    public static function register(): void
    {
        if (Manager::isStreamRegistered()) {
            Manager::unRegisterStream();
        }

        Manager::registerStream();
    }

    /**
     * Pretend we did something.
     *
     * @return bool
     */
    public function stream_open(): bool
    {
        return true;
    }

    /**
     * Generates a CSV file stream in $readSizeInBytes chunks.
     *
     * @param int $readSizeInBytes
     *
     * @return string
     *
     * @throws VCsvStreamException
     */
    public function stream_read(int $readSizeInBytes): string
    {
        $this->buffer->add($this->renderer->renderHeader());

        while (VCsvStream::hasRecords() && $readSizeInBytes > $this->buffer->currentSizeInBytes()) {
            $this->buffer->add($this->renderer->renderRecord());
        }

        $content = $this->buffer->read($readSizeInBytes);

        $this->buffer->clean($readSizeInBytes);

        return $content;
    }

    /**
     * Decides when the stream has been consumed.
     *
     * @return bool
     */
    public function stream_eof(): bool
    {
        return (VCsvStream::hasHeader() && VCsvStream::getHeader()->isFullyRendered())
            && ! VCsvStream::hasRecords()
            && 0 === $this->buffer->currentSizeInBytes();
    }

    /**
     * Provides (fake) file stats.
     *
     * @return array
     */
    public function url_stat(): array
    {
        return VCsvStream::stat();
    }
}