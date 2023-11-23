<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Rows\RowInterface;

interface StateInterface
{
    /**
     * Set the header to be rendered.
     */
    public function setHeader(RowInterface $header): void;

    /**
     * Confirm a header has been set.
     */
    public function hasHeader(): bool;

    /**
     * Get the current header.
     */
    public function getHeader(): RowInterface;

    /**
     * Add a record to be rendered.
     */
    public function addRecord(RowInterface $record): void;

    /**
     * Add a set of records to be rendered.
     *
     * @param RowInterface[] $records
     */
    public function addRecords(array $records): void;

    /**
     * Confirm one or more records have been set.
     */
    public function hasRecords(): bool;

    /**
     * Get the current record.
     *
     *
     * @throws VCsvStreamException
     */
    public function currentRecord(): RowInterface;

    /**
     * Move the record pointer to the next record.
     */
    public function nextRecord(): void;
}