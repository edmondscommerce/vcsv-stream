<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

use Faker;

class FakerValue implements GeneratorInterface
{
    /**
     * @var Faker\Generator
     */
    private $faker;

    private $property = 'text';

    private $isUnique = false;

    public function __construct(Faker\Generator $faker)
    {
        $this->faker = $faker;
    }

    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }

    public function setIsUnique($isUnique): self
    {
        $this->isUnique = $isUnique;

        return $this;
    }

    public function generate(): string
    {
        if ($this->isUnique) {
            return (string) $this->faker->unique()->{$this->property};
        }

        return (string) $this->faker->{$this->property};
    }
}