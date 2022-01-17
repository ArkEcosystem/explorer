<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;

class ClearExpiredViews extends Command
{
    public const EXPIRES_MINUTES = 60;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:clear-expired {time?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes old compiled views files';

    /**
     * Create a new config clear command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = Config::get('view.compiled');

        $expiresMinutes = (int) $this->argument('time') ?: self::EXPIRES_MINUTES;

        collect($this->files->glob("{$path}/*"))
            ->filter(fn (string $view) => $this->files->lastModified($view) < Carbon::now()->subMinutes($expiresMinutes)->getTimestamp())
            ->each(fn (string $view)   => $this->files->delete($view));

        $this->info(sprintf('Compiled views that are older than %s minute(s) cleared!', $expiresMinutes));
    }
}
