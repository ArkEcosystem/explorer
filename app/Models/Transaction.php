<?php

namespace App\Models;

use ArkEcosystem\Crypto\Configuration\Network;
use ArkEcosystem\Crypto\Transactions\Deserializer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * A transaction belongs to a block.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    /**
     * A transaction belongs to a sender.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'sender_public_key', 'public_key');
    }

    /**
     * A transaction belongs to a recipient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'recipient_id', 'address');
    }

    /**
     * Scope a query to only include transactions by the sender.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $publicKey
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSendBy($query, $publicKey)
    {
        return $query->where('sender_public_key', $publicKey);
    }

    /**
     * Scope a query to only include transactions by the recipient.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $address
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReceivedBy($query, $address)
    {
        return $query->where('recipient_id', $address);
    }

    /**
     * Get the human readable representation of the timestamp.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getTimestampCarbonAttribute(): Carbon
    {
        return Carbon::parse(Network::get()->epoch())
            ->addSeconds($this->attributes['timestamp']);
    }

    /**
     * Get the human readable representation of the vendor field.
     *
     * @return string
     */
    public function getSerializedAttribute(): string
    {
        return bin2hex(stream_get_contents($this->attributes['serialized']));
    }

    /**
     * Get the human readable representation of the vendor field.
     *
     * @return string
     */
    public function getVendorFieldAttribute(): ?string
    {
        $vendorFieldHex = $this->attributes['vendor_field_hex'];

        if (empty($vendorFieldHex)) {
            return null;
        }

        return hex2bin(stream_get_contents($vendorFieldHex));
    }

    /**
     * Get the human readable representation of the fee.
     *
     * @return float
     */
    public function getFormattedFeeAttribute(): float
    {
        return $this->fee / 1e8;
    }

    /**
     * Get the human readable representation of the amount.
     *
     * @return float
     */
    public function getFormattedAmountAttribute(): float
    {
        return $this->amount / 1e8;
    }

    /**
     * Find a wallet by its address.
     *
     * @param string $value
     *
     * @return Wallet
     */
    public static function findById(string $value): self
    {
        return static::whereId($value)->firstOrFail();
    }

    /**
     * Perform AIP11 compliant deserialisation.
     *
     * @return object
     */
    public function deserialise(): object
    {
        return Deserializer::new($this->serialized)->deserialize();
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
