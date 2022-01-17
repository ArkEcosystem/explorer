<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;

final class ClearExpiredViews extends Command
{
    public const EXPIRES_MINUTES = 60;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:clear-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes old compiled views files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = Config::get('view.compiled');

        $expiresMinutes = self::EXPIRES_MINUTES;

        $files = app(Filesystem::class);

        collect($files->glob("{$path}/*"))
            ->filter(fn (string $view) => $files->lastModified($view) < Carbon::now()->subMinutes($expiresMinutes)->getTimestamp())
            ->each(fn (string $view)   => $files->delete($view));
    }
}
