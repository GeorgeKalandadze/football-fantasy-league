<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FormatCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Format code using Laravel Pint';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $pintPath = base_path('vendor/bin/pint');
        $this->info('Formatting code using Laravel Pint...');
        exec($pintPath);
        $this->info('Code formatted successfully.');
    }
}
