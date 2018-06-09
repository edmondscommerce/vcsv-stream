<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\VCsvStream;
use BenRowan\VCsvStream\Rows\Header as HeaderRow;
use BenRowan\VCsvStream\Rows\Record as RecordRow;

class Record extends AbstractRowRenderer
{
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
    public function render(): string
    {
        if (! VCsvStream::hasRecords()) {
            return '';
        }

        /** @var RecordRow $record */
        $record = VCsvStream::currentRecord();

        /** @var HeaderRow $header */
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
}