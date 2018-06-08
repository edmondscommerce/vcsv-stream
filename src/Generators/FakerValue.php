<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

use Faker;

final class FakerValue implements GeneratorInterface
{
    /**
     * @var Faker\Generator
     */
    private $faker;

    /**
     * @var string
     */
    private $property;

    public function __construct(Faker\Generator $faker, string $property, bool $isUnique = false)
    {
        $this->faker    = $isUnique ? $faker->unique() : $faker;
        $this->property = $property;
    }

    public function generate(): string
    {
        return (string) $this->faker->{$this->property};
    }
}