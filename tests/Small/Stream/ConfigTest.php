<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Stream;

use BenRowan\VCsvStream\Stream\Config;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;

class ConfigTest extends AbstractTestCase
{
    private const FIXTURE_CONFIGURED_VALUE = 'configured_value';

    /**
     * @test
     */
    public function iGetTheDefaultDelimiterWhenNoConfigIsSet(): void
    {
        $config = new Config([]);

        $refConstant = self::$reflectionHelper
            ->createReflectionClassConstant($config, 'DEFAULT_DELIMITER');

        $expected = $refConstant->getValue();
        $actual   = $config->getDelimiter();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetTheConfiguredDelimiter(): void
    {
        $config = new Config([
            Config::DELIMITER => self::FIXTURE_CONFIGURED_VALUE
        ]);

        $expected = self::FIXTURE_CONFIGURED_VALUE;
        $actual   = $config->getDelimiter();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetTheDefaultEnclosureWhenNoConfigIsSet(): void
    {
        $config = new Config([]);

        $refConstant = self::$reflectionHelper
            ->createReflectionClassConstant($config, 'DEFAULT_ENCLOSURE');

        $expected = $refConstant->getValue();
        $actual   = $config->getEnclosure();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetTheConfiguredEnclosure(): void
    {
        $config = new Config([
            Config::ENCLOSURE => self::FIXTURE_CONFIGURED_VALUE
        ]);

        $expected = self::FIXTURE_CONFIGURED_VALUE;
        $actual   = $config->getEnclosure();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetTheDefaultNewlineWhenNoConfigIsSet(): void
    {
        $config = new Config([]);

        $refConstant = self::$reflectionHelper
            ->createReflectionClassConstant($config, 'DEFAULT_NEWLINE');

        $expected = $refConstant->getValue();
        $actual   = $config->getNewline();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetTheConfiguredNewline(): void
    {
        $config = new Config([
            Config::NEWLINE => self::FIXTURE_CONFIGURED_VALUE
        ]);

        $expected = self::FIXTURE_CONFIGURED_VALUE;
        $actual   = $config->getNewline();

        $this->assertSame($expected, $actual);
    }
}