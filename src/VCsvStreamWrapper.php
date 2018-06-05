<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Rows\Header;
use BenRowan\VCsvStream\Rows\Record;

class VCsvStreamWrapper
{
    private const PROTOCOL = 'vcsv';

    private $buffer = '';

    /**
     * @return string
     * @throws VCsvStreamException
     */
    private function renderHeader(): string
    {
        if (! VCsvStream::hasHeader()) {
            throw new VCsvStreamException(
                'No header found. You must add a CSV header before using the stream.'
            );
        }

        /** @var Header $header */
        $header = VCsvStream::getHeader();

        if ($header->isFullyRendered()) {
            return '';
        }

        $renderedRow = $this->renderRow($header->getColumnNames());

        $header->markRowRendered();

        return $renderedRow;
    }

    /**
     * Hierarchy:
     *
     *  - Record column generator
     *  - Header column generator
     *  - Generic text generator
     *
     * @return string
     * @throws VCsvStreamException
     */
    private function renderRecord(): string
    {
        if (! VCsvStream::hasRecords()) {
            return '';
        }

        /** @var Record $record */
        $record = VCsvStream::currentRecord();

        /** @var Header $header */
        $header = VCsvStream::getHeader();

        $row = [];

        foreach ($header->getColumnNames() as $columnName) {

            if ($record->hasColumnGenerator($columnName)) {
                $row[] = $record->getColumnGenerator($columnName)->generate();
                continue;
            }

            if ($header->hasColumnGenerator($columnName)) {
                $row[] = $header->getColumnGenerator($columnName)->generate();
                continue;
            }

            throw new VCsvStreamException("No generator found for column '$columnName'");
        }

        $renderedRow = $this->renderRow($row);

        $record->markRowRendered();

        if ($record->isFullyRendered()) {
            VCsvStream::nextRecord();
        }

        return $renderedRow;
    }

    private function renderRow(array $columns): string
    {
        $row = implode(
            VCsvStream::getDelimiter(),
            array_map(
                function (string $value) {
                    if (is_numeric($value)) {
                        return (string) $value;
                    }

                    return VCsvStream::getEnclosure() . $value . VCsvStream::getEnclosure();
                },
                $columns
            )
        );

        return $row . VCsvStream::getNewline();
    }

    private static function isStreamRegistered(): bool
    {
        return \in_array(self::PROTOCOL, \stream_get_wrappers(), true);
    }

    /**
     * @throws VCsvStreamException
     */
    private static function registerStream(): void
    {
        if (! stream_wrapper_register(self::PROTOCOL, self::class)) {
            throw new VCsvStreamException('VCsvStream has already been set up.');
        }
    }

    /**
     * @throws VCsvStreamException
     */
    private static function unRegisterStream(): void
    {
        if (! stream_wrapper_unregister(self::PROTOCOL)) {
            throw new VCsvStreamException('Unable to unregister the ' . self::PROTOCOL . ' stream wrapper');
        }
    }

    /**
     * @throws VCsvStreamException
     */
    public static function register(): void
    {
        if (self::isStreamRegistered()) {
            self::unRegisterStream();
        }

        self::registerStream();
    }

    public function stream_open(): bool
    {
        return true;
    }

    private function currentBufferSizeBytes(): int
    {
        return \strlen($this->buffer);
    }

    private function cleanBuffer(int $readSizeBytes): void
    {
        if ($readSizeBytes < $this->currentBufferSizeBytes()) {
            $this->buffer = \substr($this->buffer, $readSizeBytes);
            return;
        }

        $this->buffer = '';
    }

    private function readFromBuffer(int $bytes): string
    {
        return \substr($this->buffer, 0, $bytes);
    }

    /**
     * @param int $requestedReadSizeBytes
     * @return string
     * @throws VCsvStreamException
     */
    public function stream_read(int $requestedReadSizeBytes): string
    {
        $this->buffer .= $this->renderHeader();

        while (VCsvStream::hasRecords() && $requestedReadSizeBytes > $this->currentBufferSizeBytes()) {
            $this->buffer .= $this->renderRecord();
        }

        $content = $this->readFromBuffer($requestedReadSizeBytes);

        $this->cleanBuffer($requestedReadSizeBytes);

        return $content;
    }

    public function stream_eof(): bool
    {
        return (VCsvStream::hasHeader() && VCsvStream::getHeader()->isFullyRendered())
            && ! VCsvStream::hasRecords()
            && '' === $this->buffer;
    }

    public function url_stat(): array
    {
        return VCsvStream::stat();
    }
}