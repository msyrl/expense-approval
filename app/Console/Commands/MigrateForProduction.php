<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateForProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate for Production';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate:fresh', ['--force' => true]);
        $this->call('db:seed', [
            '--force' => true,
            '--class' => 'DatabaseProductionSeeder',
        ]);
        $this->info('Success migrate for production');
    }
}
