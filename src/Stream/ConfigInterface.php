<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

interface ConfigInterface
{
    /**
     * Get the currently configured delimiter character.
     *
     * @return string
     */
    public function getDelimiter(): string;

    /**
     * Get the currently configured enclosure character.
     *
     * @return string
     */
    public function getEnclosure(): string;

    /**
     * Get the currently configured newline character.
     *
     * @return string
     */
    public function getNewline(): string;
}