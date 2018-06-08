<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Generators;

use BenRowan\VCsvStream\Generators\FixedValue;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class FixedValueTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function iCanCreateAStringValue(): void
    {
        $fixedValue = new FixedValue('Hello!');

        $expected = 'Hello!';
        $actual   = $fixedValue->generate();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iCanCreateAnIntegerValue(): void
    {
        $fixedValue = new FixedValue(10);

        $expected = '10';
        $actual   = $fixedValue->generate();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iCanCreateAFloatValue(): void
    {
        $fixedValue = new FixedValue(0.1);

        $expected = '0.1';
        $actual   = $fixedValue->generate();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iCanCreateANullValue(): void
    {
        $fixedValue = new FixedValue(null);

        $expected = '';
        $actual   = $fixedValue->generate();

        $this->assertSame($expected, $actual);
    }
}