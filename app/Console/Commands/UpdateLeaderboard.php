<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\LeaderboardController;

class UpdateLeaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the leaderboard data with latest donations and claims information';

    /**
     * The LeaderboardController instance.
     *
     * @var \App\Http\Controllers\LeaderboardController
     */
    protected $leaderboardController;

    /**
     * Create a new command instance.
     *
     * @param  \App\Http\Controllers\LeaderboardController  $leaderboardController
     * @return void
     */
    public function __construct(LeaderboardController $leaderboardController)
    {
        parent::__construct();
        $this->leaderboardController = $leaderboardController;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating leaderboard data...');
        
        // Call the updateLeaderboard method from LeaderboardController
        $this->leaderboardController->updateLeaderboard();
        
        $this->info('Leaderboard data updated successfully!');
        
        return 0;
    }
}
