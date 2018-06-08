<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Assets;

use BenRowan\VCsvStream\Tests\Assets\Helpers\ReflectionHelper;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @var ReflectionHelper
     */
    protected static $reflectionHelper;

    public static function setUpBeforeClass(): void
    {
        self::$reflectionHelper = new ReflectionHelper();
    }
}