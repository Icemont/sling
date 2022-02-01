<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SlingInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sling:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete the Sling installation';

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
        $this->line('Adding initial data to the database:');

        $exe_code = $this->call('db:seed', [
            'class' => 'CurrenciesSeeder'
        ]);

        $this->info('Sling installation completed.');

        return $exe_code;
    }
}
