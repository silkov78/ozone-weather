<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MyCustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'My first custom command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("It's my custom command !");
    }
}
