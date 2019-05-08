<?php

namespace App\API\Application\Service\Report\Builder;

class ReportBuilder
{
    const REPORT_FILE = __DIR__.'report.txt';

    private $content;

    public function content(): string
    {
        return $this->content;
    }

    public function appendContent(string $text): void
    {
        $this->content .= $text;
    }

    public function generateReport(): void
    {
        $fp = fopen(self::REPORT_FILE, 'wb');
        fwrite($fp, $this->content());dump($this->content());
        fclose($fp);
    }
}
