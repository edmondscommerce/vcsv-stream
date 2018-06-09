<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\VCsvStreamWrapper;

class Manager implements ManagerInterface
{
    public static function streamIsRegistered(): bool
    {
        return \in_array(self::PROTOCOL, \stream_get_wrappers(), true);
    }

    /**
     * @throws VCsvStreamException
     */
    public static function registerStream(): void
    {
        if (! stream_wrapper_register(self::PROTOCOL, VCsvStreamWrapper::class)) {
            throw new VCsvStreamException('VCsvStream has already been set up.');
        }
    }
}