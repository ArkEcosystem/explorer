<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Facades\Network;
use App\Models\Block;
use App\Models\Transaction;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class TableCache implements Contract
{
    use Concerns\ManagesCache;

    public function latestBlocks(string $type): string
    {
        return $this->remember('latestBlocks', Network::blockTime(), fn () => Block::latestByHeight()->take(15)->get());
    }

    public function latestTransactions(string $type, array $scopes): string
    {
        return $this->remember("latestTransactions.$type", Network::blockTime(), function () use ($type, $scopes) {
            $query = Transaction::latestByTimestamp();

            if ($type !== 'all') {
                $scopeClass = $scopes[$type];

                /* @var \Illuminate\Database\Eloquent\Model */
                $query = $query->withScope($scopeClass);
            }

            return $query->take(15)->get();
        });
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('table');
    }
}
