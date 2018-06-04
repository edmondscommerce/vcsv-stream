<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Rows;

use BenRowan\VCsvStream\Generators\GeneratorInterface;

interface RowInterface
{
    public function addValueColumn(string $name, $value): RowInterface;

    public function addFakerColumn(string $name, string $property, bool $isUnique = false): RowInterface;

    public function addColumn(string $name): RowInterface;

    public function getColumnNames(): array;

    public function hasColumnGenerator(string $name): bool;

    public function getColumnGenerator(string $name): GeneratorInterface;

    public function markRowRendered(): void;

    public function isFullyRendered(): bool;
}