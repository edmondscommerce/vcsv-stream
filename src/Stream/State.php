<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Rows\RowInterface;

class State implements StateInterface
{
    /**
     * @var RowInterface The header to be used for the CSV file.
     */
    private ?RowInterface $header = null;

    /**
     * @var RowInterface[] All records to be added to the CSV file.
     */
    private array $records = [];

    /**
     * @var int Pointer to the current record to be rendered.
     */
    private int $currentRecord = 0;

    /**
     * Add a header to be rendered.
     */
    public function setHeader(RowInterface $header): void
    {
        $this->header = $header;
    }

    /**
     * Confirm a header has been set.
     */
    public function hasHeader(): bool
    {
        return null !== $this->header;
    }

    /**
     * Get the current header.
     */
    public function getHeader(): RowInterface
    {
        return $this->header;
    }

    /**
     * Add a record to be rendered.
     */
    public function addRecord(RowInterface $record): void
    {
        $this->records[] = $record;
    }

    /**
     * Add a set of records to be rendered.
     *
     * @param RowInterface[] $records
     */
    public function addRecords(array $records): void
    {
        foreach ($records as $record) {
            $this->addRecord($record);
        }
    }

    /**
     * Confirm one or more records have been set.
     */
    public function hasRecords(): bool
    {
        return \count($this->records) !== $this->currentRecord;
    }

    /**
     * Get the current record.
     *
     *
     * @throws VCsvStreamException
     */
    public function currentRecord(): RowInterface
    {
        if (! $this->hasRecords()) {
            throw new VCsvStreamException('No record available.');
        }

        return $this->records[$this->currentRecord];
    }

    /**
     * Move the record pointer to the next record.
     */
    public function nextRecord(): void
    {
        $this->currentRecord++;
    }
}