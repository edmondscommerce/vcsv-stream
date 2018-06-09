<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderer;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Rows\Header;
use BenRowan\VCsvStream\Rows\Record;
use BenRowan\VCsvStream\VCsvStream;

class Renderer implements RendererInterface
{
    /**
     * Renders the current header data as a string representing a CSV row.
     *
     * @return string
     *
     * @throws VCsvStreamException
     */
    public function renderHeader(): string
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
     * Renders the current record data as a string representing a CSV row.
     *
     * Hierarchy for generators:
     *
     *  - (1st) Record generator
     *  - (2nd) Header generator
     *
     * @return string
     *
     * @throws VCsvStreamException
     */
    public function renderRecord(): string
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

    /**
     * Handles the transformation from data to a string representing a CSV row.
     *
     * @param array $columns
     *
     * @return string
     */
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
}