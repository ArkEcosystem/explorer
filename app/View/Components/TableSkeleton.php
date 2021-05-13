<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

final class TableSkeleton extends Component
{
    private Collection $items;

    public function __construct(private string $device, array $items)
    {
        $this->items   = collect($items);
    }

    public function render(): View
    {
        if ($this->device === 'desktop') {
            $headers = $this->items->map(function ($item) {
                return array_merge(
                    ['component' => "tables.headers.{$this->device}." . $this->getName($item)],
                    $this->getOptions($item)
                );
            });
            $rows    = $this->items->values()->map(function ($item) {
                return array_merge(
                    ['component' => "tables.rows.{$this->device}.skeletons." . $this->getName($item)],
                    $this->getOptions($item)
                );
            });
        } else {
            $headers = collect([]); // Mobile has no separate headers
            $rows    = $this->items->map(function ($item) {
                return array_merge(
                    ['component' => "tables.rows.{$this->device}.skeletons." . $this->getName($item)],
                    $this->getOptions($item)
                );
            });
        }


        return view("components.tables.skeletons.{$this->device}", [
            'headers' => $headers->toArray(),
            'rows'    => $rows->toArray(),
        ]);
    }

    private function getName(array|string $item): string
    {
        if (is_string($item)) {
            return $item;
        }

        return Arr::get($item, 'name', '');
    }

    private function getOptions(array|string $item): array
    {
        if (is_string($item)) {
            return [];
        }

        return $item;
    }
}
