<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Stream;

interface FileInterface
{
    /**
     * Returns some fake stats for the CSV file.
     */
    public function stat(): array;
}