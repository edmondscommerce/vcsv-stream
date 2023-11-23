<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Generators;

use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Iterator;
use OverflowException;
use BenRowan\VCsvStream\Generators\FakerValue;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;
use Faker;

class FakerValueTest extends AbstractTestCase
{
    private $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();
        $this->faker->seed(1);
    }

    
    #[DataProvider('iCanGenerateValuesDataProvider')]
    #[Test]
    public function iCanGenerateValues(string $property): void
    {
        $fakerValue = new FakerValue($this->faker, $property);

        $this->assertNotEmpty($fakerValue->generate());
    }

    public static function iCanGenerateValuesDataProvider(): Iterator
    {
        yield ['text'];
        yield ['randomNumber'];
        yield ['randomFloat'];
        yield ['email'];
    }

    #[Test]
    public function iCanGenerateUniqueValues(): void
    {
        // Faker throws this when it runs out of unique values.
        $this->expectException(OverflowException::class);

        $fakerValue = new FakerValue($this->faker, 'randomDigitNotNull', true);

        while (true) {
            $fakerValue->generate();
        }
    }
}