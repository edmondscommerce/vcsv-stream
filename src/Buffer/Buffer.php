<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Buffer;

class Buffer implements BufferInterface
{
    private $buffer = '';

    /**
     * Get the current size of the buffer in bytes.
     *
     * @return int
     */
    public function currentSizeInBytes(): int
    {
        return \strlen($this->buffer);
    }

    /**
     * Removes $bytes bytes from the start of the buffer.
     *
     * @param int $bytes
     */
    public function clean(int $bytes): void
    {
        if ($bytes < $this->currentSizeInBytes()) {
            $this->buffer = \substr($this->buffer, $bytes);
            return;
        }

        // If the number of bytes to be cleaned are greater then the current
        // number of bytes in the buffer then we simple clean all content.
        $this->buffer = '';
    }

    /**
     * Reads $bytes bytes from the start of the buffer.
     *
     * @param int $bytes
     *
     * @return string
     */
    public function read(int $bytes): string
    {
        return \substr($this->buffer, 0, $bytes);
    }

    /**
     * Adds content to the buffer.
     *
     * @param string $content
     */
    public function add(string $content): void
    {
        $this->buffer .= $content;
    }
}