<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

final class FixedValue implements GeneratorInterface
{
    private $value;

    /**
     * Create a fixed value generator.
     *
     * @param mixed $value Anything which can be cast to a string.
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Generate a fixed value.
     *
     * @return string
     */
    public function generate(): string
    {
        return (string) $this->value;
    }
}