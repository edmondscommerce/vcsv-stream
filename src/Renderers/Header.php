<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

use BenRowan\VCsvStream\Exceptions\VCsvStreamException;
use BenRowan\VCsvStream\VCsvStream;
use BenRowan\VCsvStream\Rows\Header as HeaderRow;

class Header extends AbstractRowRenderer
{
    /**
     * Renders the current header data as a CSV row string.
     *
     * @return string
     *
     * @throws VCsvStreamException
     */
    public function render(): string
    {
        if (! VCsvStream::hasHeader()) {
            throw new VCsvStreamException(
                'No header found. You must add a CSV header before using the stream.'
            );
        }

        /** @var HeaderRow $header */
        $header = VCsvStream::getHeader();

        if ($header->isFullyRendered()) {
            return '';
        }

        $renderedRow = $this->renderRow($header->getColumnNames());

        $header->markRowRendered();

        return $renderedRow;
    }
}