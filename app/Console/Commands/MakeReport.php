<?php

namespace App\Console\Commands;

use App\Services\ReportService;
use Illuminate\Console\Command;

class MakeReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ReportService $reportService)
    {
        $templateProcessor = $reportService->makeFirstTypeReport(
            '2022-04-06 00:00:00',
            '2022-04-06 00:20:00',
            'T3950713'
        );

        $templateProcessor->saveAs('report.docx');
    }
}
