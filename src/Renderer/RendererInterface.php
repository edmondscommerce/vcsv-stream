<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderer;

interface RendererInterface
{
    public function renderHeader(): string;

    public function renderRecord(): string;
}