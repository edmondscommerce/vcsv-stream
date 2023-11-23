<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

use BenRowan\VCsvStream\Stream\ConfigInterface;
use BenRowan\VCsvStream\Stream\StateInterface;
use BenRowan\VCsvStream\Stream;

interface RowRendererInterface
{
    public function render(ConfigInterface $config, StateInterface $streamState): string;
}