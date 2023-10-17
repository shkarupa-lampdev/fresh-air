<?php

namespace App\Console\Commands;

use App\Services\SplitServices\SplitBaseService;
use Illuminate\Console\Command;

class setdailysplits extends Command
{
    protected SplitBaseService $splitService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'splits:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store splits for daily frames';

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
            while (!$locationService->isLastDailySplit()) {
                $lastDailyTime = $locationService->getLastDaily();

                $splitData = $locationService->getRepository()->getSplit(
                    $lastDailyTime,
                    $lastDailyTime->copy()->addHours(24)->subSecond()
                );

                $locationService->getRepository()->createDailySplit(
                    $splitData,
                    $lastDailyTime,
                    $lastDailyTime->copy()->addHours(24)->subSecond()
                );
            }
        }
    }
}
