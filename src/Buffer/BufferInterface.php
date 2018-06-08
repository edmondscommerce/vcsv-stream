<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Buffer;

interface BufferInterface
{
    public function currentSizeInBytes(): int;

    public function clean(int $bytes): void;

    public function read(int $bytes): string;

    public function add(string $content): void;
}