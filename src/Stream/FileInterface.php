<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

interface FileInterface
{
    /**
     * Returns some fake stats for the CSV file.
     *
     * @return array
     */
    public function stat(): array;
}