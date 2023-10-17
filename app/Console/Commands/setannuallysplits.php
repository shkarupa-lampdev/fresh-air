<?php

namespace App\Console\Commands;

use App\Services\SplitServices\SplitBaseService;
use Illuminate\Console\Command;

class setannuallysplits extends Command
{
    protected SplitBaseService $splitService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'splits:annually';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            while (!$locationService->isLastAnnuallySplit()) {
                $lastDailyTime = $locationService->getLastAnnually();

                $splitData = $locationService->getRepository()->getSplit(
                    $lastDailyTime,
                    $lastDailyTime->copy()->addYear()->subSecond()
                );

                $locationService->getRepository()->createAnnuallySplit(
                    $splitData,
                    $lastDailyTime,
                    $lastDailyTime->copy()->addYear()->subSecond()
                );
            }
        }
    }
}
