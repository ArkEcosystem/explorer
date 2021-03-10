<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\SearchesCaseInsensitive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $public_key
 * @property int $missed_blocks
 * @property int $forged_blocks
 */
final class ForgingStats extends Model
{
    use HasFactory;
    use SearchesCaseInsensitive;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    public $keyType = 'string';

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
        'public_key'    => 'string',
        'missed_blocks' => 'int',
        'forged_blocks' => 'int',
    ];

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
