<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Buffer\Buffer;
use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Renderers;
use BenRowan\VCsvStream\Stream;

class VCsvStreamWrapper
{
    private $buffer;

    private $headerRenderer;

    private $recordRenderer;

    public function __construct()
    {
        $this->buffer         = new Buffer();
        $this->headerRenderer = new Renderers\Header();
        $this->recordRenderer = new Renderers\Record();
    }

    /**
     * Register this stream wrapper with the vcsv protocol.
     *
     * @throws VCsvStreamException
     */
    public static function setup(): void
    {
        if (Stream\Manager::streamIsRegistered()) {
            return;
        }

        Stream\Manager::registerStream();
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
     *
     * @return bool
     */
    public function stream_eof(): bool
    {
        $streamState = VCsvStream::getState();

        return ($streamState->hasHeader() && $streamState->getHeader()->isFullyRendered())
            && ! $streamState->hasRecords()
            && 0 === $this->buffer->currentSizeInBytes();
    }

    /**
     * Returns some fake stats for the CSV file.
     *
     * @return array
     */
    public function url_stat(): array
    {
        return VCsvStream::getFile()->stat();
    }
}