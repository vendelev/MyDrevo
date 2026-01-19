<?php

declare(strict_types=1);

namespace App\Example\Application\Responder;

use App\Example\Application\Dto\Calculated;

final readonly class ExampleReportResponder
{
    /**
     * @param list<Calculated> $data
     */
    public function render(array $data, string $format = 'md'): string
    {
        if ($format !== 'md') {
            return '-';
        }

        $templatePath = __DIR__ . '/Template/ExampleReport.md';
        $template = file_get_contents($templatePath);

        $rows = '';
        foreach ($data as $calculated) {
            $rows .= "| {$calculated->number1} | {$calculated->number2} | {$calculated->result} |\n";
        }

        return str_replace('| n1      | n2      | result    |', $rows, (string)$template);
    }
}
