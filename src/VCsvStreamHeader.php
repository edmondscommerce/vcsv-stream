<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Generators\GeneratorFactory;
use BenRowan\VCsvStream\Generators\GeneratorInterface;

class VCsvStreamHeader
{
    private $columns = [];

    public function addFixedValueColumn(string $name, $value): self
    {
        $this->columns[$name] = GeneratorFactory::createFixedValue($value);

        return $this;
    }

    public function addFakerValueColumn(string $name, string $property, bool $isUnique = false): self
    {
        $this->columns[$name] = GeneratorFactory::createFakerValue($property, $isUnique);

        return $this;
    }

    public function addColumn(string $name): self
    {
        $this->columns[$name] = GeneratorFactory::createFakerValue();

        return $this;
    }

    public function getColumnNames(): array
    {
        return \array_keys($this->columns);
    }

    /**
     *
     *
     * @param string $name
     * @return GeneratorInterface
     * @throws VCsvStreamException
     */
    public function getColumn(string $name): GeneratorInterface
    {
        if (! isset($this->columns[$name])) {
            throw new VCsvStreamException("Column '$name' not found.");
        }

        return $this->columns[$name];
    }
}