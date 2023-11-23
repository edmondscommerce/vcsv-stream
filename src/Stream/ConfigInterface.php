<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

interface ConfigInterface
{
    /**
     * Get the currently configured delimiter character.
     */
    public function getDelimiter(): string;

    /**
     * Get the currently configured enclosure character.
     */
    public function getEnclosure(): string;

    /**
     * Get the currently configured newline character.
     */
    public function getNewline(): string;
}