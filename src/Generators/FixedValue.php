<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

final class FixedValue implements GeneratorInterface
{
    /**
     * Create a fixed value generator.
     *
     * @param mixed $value Anything which can be cast to a string.
     */
    public function __construct(private readonly mixed $value)
    {
    }

    /**
     * Generate a fixed value.
     */
    public function generate(): string
    {
        return (string) $this->value;
    }
}