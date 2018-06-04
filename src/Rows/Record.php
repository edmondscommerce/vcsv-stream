<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Rows;

class Record extends AbstractRow
{
    private $rowCount;

    public function __construct(int $rowCount)
    {
        $this->rowCount = $rowCount;
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