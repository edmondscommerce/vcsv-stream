<?php declare(strict_types=1);

namespace BenRowan\VCsvStream;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use Faker;

class VCsvStreamWrapper
{
    public const PROTOCOL = 'vcsv';

    /**
     * @var Faker\Factory
     */
    private static $faker;

    private $header = ['One', 'Two'];

    private $hasHeader = true;

    private $headerHasBeenOutput = false;

    private $remainingRows = 1000;

    private $content = '';

    private function outputHeader(): string
    {
        $header = '';

        if (! $this->hasHeader) {
            return $header;
        }

        if ($this->headerHasBeenOutput) {
            return $header;
        }

        $this->headerHasBeenOutput = true;

        return implode(', ', $this->header) . "\n";
    }

    private function outputRow(): string
    {
        $row = [
            '"' . self::$faker->text . '"',
            '"' . self::$faker->text . '"'
        ];

        $this->remainingRows--;

        return implode(', ', $row) . "\n";
    }

    private static function isStreamRegistered(): bool
    {
        return \in_array(self::PROTOCOL, \stream_get_wrappers(), true);
    }

    /**
     * @throws VCsvStreamException
     */
    private static function registerStream(): void
    {
        if (! stream_wrapper_register(self::PROTOCOL, self::class)) {
            throw new VCsvStreamException('VCsvStream has already been set up.');
        }
    }

    /**
     * @throws VCsvStreamException
     */
    private static function unRegisterStream(): void
    {
        if (! stream_wrapper_unregister(self::PROTOCOL)) {
            throw new VCsvStreamException('Unable to unregister the ' . self::PROTOCOL . ' stream wrapper');
        }
    }

    /**
     * @throws VCsvStreamException
     */
    public static function register(): void
    {
        if (self::isStreamRegistered()) {
            self::unRegisterStream();
        }

        self::registerStream();

        self::$faker = Faker\Factory::create();
    }

    public function stream_open(string $path , string $mode , int $options , ?string &$opened_path): bool
    {
        return true;
    }

    public function stream_read(int $count): string
    {
        while ($this->remainingRows > 0 && $count > \strlen($this->content)) {
            $this->content .= $this->outputHeader();
            $this->content .= $this->outputRow();
        }

        $read = substr($this->content, 0, $count);

        if ($count < \strlen($this->content)) {
            $this->content = substr($this->content, $count);
        }
        else {
            $this->content = '';
        }

        return $read;
    }

    public function stream_eof(): bool
    {
        return 0 === $this->remainingRows && '' === $this->content;
    }

    public function url_stat(): array
    {
        return VCsvStream::stat();
    }
}