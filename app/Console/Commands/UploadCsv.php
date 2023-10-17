<?php

namespace App\Console\Commands;

use App\Services\UploadCSVService;
use Illuminate\Console\Command;

class UploadCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse and store big csv files';

    /**
     * Execute the console command.
     */
    public function handle(UploadCSVService $uploadCSVService)
    {
        // documentation/1748.csv
        // documentation/test.example.csv
        $filePath = $this->ask('Напишіть повний шлях до файлу:');

        if (!file_exists($filePath)) {
            $this->error('Файл з даним шляхом не існує!');
            exit(1);
        }

        $uploadCSVService->uploadCSVFromCommand($filePath);

        $this->info('Файл успішно переданий у функцію.');
    }
}
