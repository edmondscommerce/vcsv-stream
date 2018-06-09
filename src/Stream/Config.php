<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

class Config implements ConfigInterface
{
    /**
     * Configuration keys.
     */

    public const DELIMITER = 'delimiter';

    public const ENCLOSURE = 'enclosure';

    public const NEWLINE   = 'newline';

    /**
     * Default values.
     */

    private const DEFAULT_DELIMITER = ',';

    private const DEFAULT_ENCLOSURE = '"';

    private const DEFAULT_NEWLINE   = "\n";

    /**
     * @var array All VCsvStream configuration.
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get the currently configured delimiter character.
     *
     * @return string
     */
    public function getDelimiter(): string
    {
        if (isset($this->config[self::DELIMITER])) {
            return $this->config[self::DELIMITER];
        }

        return self::DEFAULT_DELIMITER;
    }

    /**
     * Get the currently configured enclosure character.
     *
     * @return string
     */
    public function getEnclosure(): string
    {
        if (isset($this->config[self::ENCLOSURE])) {
            return $this->config[self::ENCLOSURE];
        }

        return self::DEFAULT_ENCLOSURE;
    }

    /**
     * Get the currently configured newline character.
     *
     * @return string
     */
    public function getNewline(): string
    {
        if (isset($this->config[self::NEWLINE])) {
            return $this->config[self::NEWLINE];
        }

        return self::DEFAULT_NEWLINE;
    }
}