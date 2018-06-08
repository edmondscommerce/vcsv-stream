<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

interface ManagerInterface
{
    public const PROTOCOL = 'vcsv';

    public static function isStreamRegistered(): bool;

    public static function registerStream(): void;

    public static function unRegisterStream(): void;
}