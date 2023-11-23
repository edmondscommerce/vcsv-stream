<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

use Faker\Generator;
use Faker;

final class FakerValue implements GeneratorInterface
{
    /**
     * @var Faker\Generator
     */
    private $faker;

    public function __construct(Generator $faker, private readonly string $property, bool $isUnique = false)
    {
        $this->faker    = $isUnique ? $faker->unique() : $faker;
    }

    public function generate(): string
    {
        return (string) $this->faker->{$this->property};
    }
}