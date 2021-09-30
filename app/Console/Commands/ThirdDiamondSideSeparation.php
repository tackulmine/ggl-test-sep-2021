<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ThirdDiamondSideSeparation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'third:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Third Diamond Side Separation';

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
        $n = $this->ask('Please input half of the max rows diamond');

        for ($i=1; $i <= $n; $i++) {
            $print = '';
            for ($s=$i; $s < $n; $s++) {
                $print .= ' ';
            }

            for ($j=1; $j <= $i; $j++) {
                $print .= '*';
            }

            $print .= '     ';

            for ($j=1; $j <= $i; $j++) {
                $print .= '*';
            }

            $this->info($print);
        }

        $this->line('');
        $this->line('');

        for ($i=$n; $i > 0; $i--) {
            $print = '';
            for ($s=1; $s <= $n-$i; $s++) {
                $print .= ' ';
            }

            for ($j=$i; $j > 0; $j--) {
                $print .= '*';
            }

            $print .= '     ';

            for ($j=$i; $j > 0; $j--) {
                $print .= '*';
            }

            $this->info($print);
        }

        return 0;
    }
}
