<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

use BenRowan\VCsvStream\VCsvStream;

abstract class AbstractRowRenderer implements RowRendererInterface
{
    /**
     * Handles the transformation of column data into a CSV row string.
     *
     * @param array $columns
     *
     * @return string
     */
    protected function renderRow(array $columns): string
    {
        $row = implode(
            VCsvStream::getDelimiter(),
            array_map(
                function (string $value) {
                    if (is_numeric($value)) {
                        return (string) $value;
                    }

                    return VCsvStream::getEnclosure() . $value . VCsvStream::getEnclosure();
                },
                $columns
            )
        );

        return $row . VCsvStream::getNewline();
    }
}