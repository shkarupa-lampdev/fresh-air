<?php

namespace App\Console\Commands;

use App\Services\SplitServices\SplitBaseService;
use Illuminate\Console\Command;

class set20msplits extends Command
{
    protected SplitBaseService $splitService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'splits:20mins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store splits for 20 min time frames';

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
            while (!$locationService->isLast20mSplit()) {
                $last20mTime = $locationService->getLast20m();

                $splitData = $locationService->get20split(
                    $last20mTime,
                    $last20mTime->copy()->addMinutes(20)->subSecond()
                );

                $locationService->getRepository()->create($splitData);
            }
        }
    }
}
