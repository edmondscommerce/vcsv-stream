<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

use BenRowan\VCsvStream\Stream;

interface RowRendererInterface
{
    public function render(Stream\ConfigInterface $config, Stream\StateInterface $streamState): string;
}