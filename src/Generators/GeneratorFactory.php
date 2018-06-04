<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

use Faker;

class GeneratorFactory
{
    /**
     * @var Faker\Generator
     */
    private static $faker;

    public static function setup(): void
    {
        self::$faker = Faker\Factory::create();
    }

    public static function createFixedValue($value): GeneratorInterface
    {
        $fixedValue = new FixedValue();

        $fixedValue->setValue($value);

        return $fixedValue;
    }

    public static function createFakerValue(string $property = 'text', bool $isUnique = false): GeneratorInterface
    {
        $fakerValue = new FakerValue(self::$faker);

        $fakerValue
            ->setProperty($property)
            ->setIsUnique($isUnique);

        return $fakerValue;
    }
}