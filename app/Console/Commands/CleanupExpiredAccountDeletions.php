<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CleanupExpiredAccountDeletions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:cleanup-expired-deletions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete user accounts that have exceeded their deletion grace period';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of expired account deletions...');
        
        try {
            $deletedCount = User::processExpiredDeletions();
            
            if ($deletedCount > 0) {
                $this->info("Successfully deleted {$deletedCount} expired account(s).");
            } else {
                $this->info('No expired accounts found for deletion.');
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to cleanup expired account deletions: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
