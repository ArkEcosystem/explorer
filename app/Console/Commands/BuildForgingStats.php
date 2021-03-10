<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\BuildForgingStats;
use Illuminate\Console\Command;

final class BuildForgingStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forging-stats:build {--height=} {--days=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build forging stats into forging_stats database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $height = (int) $this->argument('height');
        $days   = (int) $this->argument('days');
        (new BuildForgingStats($height, $days))->handle();
    }
}
