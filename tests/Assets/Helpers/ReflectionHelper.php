<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Assets\Helpers;

use ReflectionProperty;
use ReflectionException;
use ReflectionClassConstant;
use PHPUnit\Runner\Exception;

class ReflectionHelper
{
    public function createReflectionProperty($object, string $property): ReflectionProperty
    {
        try {
            $refProp = new ReflectionProperty($object, $property);
            $refProp->setAccessible(true);

            return $refProp;
        }
        catch (ReflectionException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function createReflectionClassConstant($object, string $constant): ReflectionClassConstant
    {
        return new ReflectionClassConstant($object, $constant);
    }
}