<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Rows;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Generators\GeneratorInterface;

abstract class AbstractRow implements RowInterface
{
    protected $columns = [];

    public function addValueColumn(string $name, $value): RowInterface
    {
        $this->columns[$name] = GeneratorFactory::createFixedValue($value);

        return $this;
    }

    public function addFakerColumn(string $name, string $property, bool $isUnique = false): RowInterface
    {
        $this->columns[$name] = GeneratorFactory::createFakerValue($property, $isUnique);

        return $this;
    }

    public function addColumn(string $name): RowInterface
    {
        $this->columns[$name] = GeneratorFactory::createFakerValue();

        return $this;
    }

    public function getColumnNames(): array
    {
        return \array_keys($this->columns);
    }

    public function hasColumnGenerator(string $name): bool
    {
        return isset($this->columns[$name]);
    }

    /**
     *
     *
     * @throws VCsvStreamException
     */
    public function getColumnGenerator(string $name): GeneratorInterface
    {
        if (! isset($this->columns[$name])) {
            throw new VCsvStreamException("Column '$name' not found.");
        }

        return $this->columns[$name];
    }

    abstract public function markRowRendered(): void;

    abstract public function isFullyRendered(): bool;
}