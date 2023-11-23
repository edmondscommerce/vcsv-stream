<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Renderers;

use BenRowan\VCsvStream\Stream\ConfigInterface;
use BenRowan\VCsvStream\Stream;

abstract class AbstractRowRenderer implements RowRendererInterface
{
    /**
     * Handles the transformation of column data into a CSV row string.
     *
     *
     */
    protected function renderRow(ConfigInterface $config, array $columns): string
    {
        $row = implode(
            $config->getDelimiter(),
            array_map(
                function (string $value) use ($config) {
                    if (is_numeric($value)) {
                        return (string) $value;
                    }

                    return $config->getEnclosure() . $value . $config->getEnclosure();
                },
                $columns
            )
        );

        return $row . $config->getNewline();
    }
}