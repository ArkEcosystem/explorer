<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

final class TableSkeleton extends Component
{
    private string $device;

    private array $headers;

    private array $rows;

    public function __construct(string $device, array $headers, array $rows)
    {
        $this->device  = $device;
        $this->headers = $headers;
        $this->rows    = $rows;
    }

    public function render(): View
    {
        $headers = collect($this->headers)->map(fn ($name) => "tables.headers.{$this->device}.$name");
        $rows    = collect($this->rows)->map(fn ($name) => "tables.rows.{$this->device}.skeletons.$name");

        /* @phpstan-ignore-next-line */
        return view("components.tables.skeletons.{$this->device}", [
            'headers' => $headers->toArray(),
            'rows'    => $rows->toArray(),
        ]);
    }
}
