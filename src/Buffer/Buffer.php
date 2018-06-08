<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Buffer;

class Buffer implements BufferInterface
{
    private $buffer = '';

    public function currentSizeInBytes(): int
    {
        return \strlen($this->buffer);
    }

    public function clean(int $bytes): void
    {
        if ($bytes < $this->currentSizeInBytes()) {
            $this->buffer = \substr($this->buffer, $bytes);
            return;
        }

        $this->buffer = '';
    }

    public function read(int $bytes): string
    {
        return \substr($this->buffer, 0, $bytes);
    }

    public function add(string $content): void
    {
        $this->buffer .= $content;
    }
}