<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Rows;

class Header extends AbstractRow
{
    private bool $rendered = false;

    public function markRowRendered(): void
    {
        $this->rendered = true;
    }

    public function isFullyRendered(): bool
    {
        return $this->rendered;
    }
}