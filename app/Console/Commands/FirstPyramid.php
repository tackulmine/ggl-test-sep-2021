<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FirstPyramid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'first:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'First Pyramid';

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
        $n = $this->ask('Please input the max rows of pyramid');

        if ($n > 0) {
            for ($i=1; $i <= $n; $i++) {
                $print = '';

                for ($s=$i; $s <= $n-1; $s++) {
                    $print .= ' ';
                }

                for ($j=0; $j < $i*2-1; $j++) {
                    $print .= '*';
                }

                $this->info($print);
            }
        }

        return 0;
    }
}
