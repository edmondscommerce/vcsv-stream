<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

class Config implements ConfigInterface
{
    /**
     * Configuration keys.
     */

    final public const DELIMITER = 'delimiter';

    final public const ENCLOSURE = 'enclosure';

    final public const NEWLINE   = 'newline';

    /**
     * Default values.
     */

    private const DEFAULT_DELIMITER = ',';

    private const DEFAULT_ENCLOSURE = '"';

    private const DEFAULT_NEWLINE   = "\n";

    public function __construct(
        /**
         * @var array All VCsvStream configuration.
         */
        private array $config
    )
    {
    }

    /**
     * Get the currently configured delimiter character.
     */
    public function getDelimiter(): string
    {
        return $this->config[self::DELIMITER] ?? self::DEFAULT_DELIMITER;
    }

    /**
     * Get the currently configured enclosure character.
     */
    public function getEnclosure(): string
    {
        return $this->config[self::ENCLOSURE] ?? self::DEFAULT_ENCLOSURE;
    }

    /**
     * Get the currently configured newline character.
     */
    public function getNewline(): string
    {
        return $this->config[self::NEWLINE] ?? self::DEFAULT_NEWLINE;
    }
}