<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Rows;

class Record extends AbstractRow
{
    public function __construct(private int $rowCount)
    {
    }

    public function markRowRendered(): void
    {
        $this->rowCount--;
    }

    public function isFullyRendered(): bool
    {
        return 0 === $this->rowCount;
    }
}
