<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Generators;

interface GeneratorInterface
{
    public function generate(): string;
}