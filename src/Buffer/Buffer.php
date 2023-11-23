<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Buffer;

class Buffer implements BufferInterface
{
    private string $buffer = '';

    /**
     * Get the current size of the buffer in bytes.
     */
    public function currentSizeInBytes(): int
    {
        return \strlen((string) $this->buffer);
    }

    /**
     * Removes $bytes bytes from the start of the buffer.
     */
    public function clean(int $bytes): void
    {
        if ($bytes < $this->currentSizeInBytes()) {
            $this->buffer = \substr((string) $this->buffer, $bytes);
            return;
        }

        // If the number of bytes to be cleaned are greater then the current
        // number of bytes in the buffer then we simple clean all content.
        $this->buffer = '';
    }

    /**
     * Reads $bytes bytes from the start of the buffer.
     *
     *
     */
    public function read(int $bytes): string
    {
        return \substr((string) $this->buffer, 0, $bytes);
    }

    /**
     * Adds content to the buffer.
     */
    public function add(string $content): void
    {
        $this->buffer .= $content;
    }
}