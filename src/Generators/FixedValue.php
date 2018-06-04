<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

class FixedValue implements GeneratorInterface
{
    private $value = '';

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function generate(): string
    {
        return (string) $this->value;
    }
}