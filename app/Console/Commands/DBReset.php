<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DBReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset';

    /**
     * @var string
     */
    protected $description = 'Deletes all the survey data from the database!!! Be carefully! This job runs once per night at 03:00.';

    /**
     * Execute the console command.
     */
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('wipe database');
        Artisan::call('db:wipe');

        $this->info('migrate data');
        Artisan::call('migrate --seed');

    }
}
