<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

use Faker\Factory;
use Faker;

class GeneratorFactory
{
    /**
     * @var Faker\Generator
     */
    private static $faker;

    /**
     * Sets up the factory.
     */
    public static function setup(): void
    {
        self::$faker = Factory::create();
    }

    /**
     * Create a fixed value generator.
     *
     * @param mixed $value Any value which can be cast to a string.
     */
    public static function createFixedValue(mixed $value): GeneratorInterface
    {
        return new FixedValue($value);
    }

    /**
     * Create a faker value generator.
     *
     * @param string $property The faker property to use to generate your value.
     * @param bool $isUnique Whether you need the value to be unique.
     */
    public static function createFakerValue(string $property = 'text', bool $isUnique = false): GeneratorInterface
    {
        return new FakerValue(self::$faker, $property, $isUnique);
    }
}