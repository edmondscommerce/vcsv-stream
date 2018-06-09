<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\Stream;
use BenRowan\VCsvStream\Rows\Header as HeaderRow;

class Header extends AbstractRowRenderer
{
    /**
     * Renders the current header data as a CSV row string.
     *
     * @param Stream\ConfigInterface $config
     * @param Stream\StateInterface $streamState
     *
     * @return string
     *
     * @throws VCsvStreamException
     */
    public function render(Stream\ConfigInterface $config, Stream\StateInterface $streamState): string
    {
        if (! $streamState->hasHeader()) {
            throw new VCsvStreamException(
                'No header found. You must add a CSV header before using the stream.'
            );
        }

        /** @var HeaderRow $header */
        $header = $streamState->getHeader();

        if ($header->isFullyRendered()) {
            return '';
        }

        $renderedRow = $this->renderRow($config, $header->getColumnNames());

        $header->markRowRendered();

        return $renderedRow;
    }
}