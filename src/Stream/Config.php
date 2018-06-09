<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

class Config implements ConfigInterface
{
    /**
     * Configuration keys.
     */

    public const CONFIG_DELIMITER = 'delimiter';

    public const CONFIG_ENCLOSURE = 'enclosure';

    public const CONFIG_NEWLINE   = 'newline';

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
        if (isset($this->config[self::CONFIG_DELIMITER])) {
            return $this->config[self::CONFIG_DELIMITER];
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
        if (isset($this->config[self::CONFIG_ENCLOSURE])) {
            return $this->config[self::CONFIG_ENCLOSURE];
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
        if (isset($this->config[self::CONFIG_NEWLINE])) {
            return $this->config[self::CONFIG_NEWLINE];
        }

        return self::DEFAULT_NEWLINE;
    }
}