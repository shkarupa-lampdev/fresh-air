<?php

namespace App\Console\Commands;

use App\Services\SplitServices\SplitBaseService;
use Illuminate\Console\Command;

class setmonthlysplits extends Command
{
    protected SplitBaseService $splitService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'splits:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store splits for monthly frames';

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
            while (!$locationService->isLastMonthlySplit()) {
                $lastDailyTime = $locationService->getLastMonthly();

                $splitData = $locationService->getRepository()->getSplit(
                    $lastDailyTime,
                    $lastDailyTime->copy()->addMonth()->subSecond()
                );

                $locationService->getRepository()->createMonthlySplit(
                    $splitData,
                    $lastDailyTime,
                    $lastDailyTime->copy()->addMonth()->subSecond()
                );
            }
        }
    }
}
