<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Casts\BigInteger;
use App\Services\BigNumber;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $round
 * @property BigNumber $balance
 */
final class Round extends Model
{
    // use Cachable;
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'balance' => BigInteger::class,
    ];

    /**
     * A round slot belongs to a delegate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delegate(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'public_key', 'public_key');
    }

    /**
     * Scope a query to sort rounds by number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNumber($query): Builder
    {
        return $query->orderBy('round', 'desc');
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return 'explorer';
    }
}
