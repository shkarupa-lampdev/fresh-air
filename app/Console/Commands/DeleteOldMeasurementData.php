<?php

namespace App\Console\Commands;

use App\Services\SplitServices\SplitBaseService;
use Illuminate\Console\Command;

class DeleteOldMeasurementData extends Command
{
    protected SplitBaseService $splitService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-measurement-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete measurement data older then 3 months';

    public function __construct(
        SplitBaseService $splitService,
    ) {
        parent::__construct();
        $this->splitService = $splitService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->splitService->getLocationServices() as $locationService) {
            $locationService->deleteOldRecords();
        }
    }
}
