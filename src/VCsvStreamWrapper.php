<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Renderers\Header;
use BenRowan\VCsvStream\Renderers\Record;
use BenRowan\VCsvStream\Stream\Manager;
use BenRowan\VCsvStream\Buffer\Buffer;
use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Renderers;
use BenRowan\VCsvStream\Stream;

class VCsvStreamWrapper
{
    private readonly Buffer $buffer;

    private readonly Header $headerRenderer;

    private readonly Record $recordRenderer;

    public function __construct()
    {
        $this->buffer         = new Buffer();
        $this->headerRenderer = new Header();
        $this->recordRenderer = new Record();
    }

    /**
     * Register this stream wrapper with the vcsv protocol.
     *
     * @throws VCsvStreamException
     */
    public static function setup(): void
    {
        if (Manager::streamIsRegistered()) {
            return;
        }

        Manager::registerStream();
    }

    /**
     * Pretend we did something.
     */
    public function stream_open(): bool
    {
        return true;
    }

    /**
     * Generates a CSV file stream in $readSizeInBytes chunks.
     *
     *
     *
     * @throws VCsvStreamException
     */
    public function stream_read(int $readSizeInBytes): string
    {
        $config      = VCsvStream::getConfig();
        $streamState = VCsvStream::getState();

        $this->buffer->add($this->headerRenderer->render($config, $streamState));

        while ($streamState->hasRecords() && $readSizeInBytes > $this->buffer->currentSizeInBytes()) {
            $this->buffer->add($this->recordRenderer->render($config, $streamState));
        }

        $content = $this->buffer->read($readSizeInBytes);

        $this->buffer->clean($readSizeInBytes);

        return $content;
    }

    /**
     * Decides when the stream has been consumed.
     */
    public function stream_eof(): bool
    {
        $streamState = VCsvStream::getState();

        return $streamState->getHeader()->isFullyRendered()
            && ! $streamState->hasRecords()
            && 0 === $this->buffer->currentSizeInBytes();
    }

    /**
     * Returns some fake stats for the CSV file.
     */
    public function url_stat(): array
    {
        return VCsvStream::getFile()->stat();
    }
}