<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Rows;

class NoHeader extends AbstractRow
{
    public function markRowRendered(): void
    {
        // Do nothing
    }

    public function isFullyRendered(): bool
    {
        return true;
    }
}