<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

interface RowRendererInterface
{
    public function render(): string;
}