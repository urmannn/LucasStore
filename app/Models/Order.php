<?php

namespace App\Models;

use App\Support\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_SHIPPED = 'shipped';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_UNPAID = 'unpaid';

    public const PAYMENT_PAID = 'paid';

    public const PAYMENT_REFUNDED = 'refunded';

    public const STATUS_META = [
        self::STATUS_PENDING => ['label' => 'Menunggu Pembayaran', 'badge' => 'bg-orange-100 text-orange-800 border-orange-200'],
        self::STATUS_PAID => ['label' => 'Sudah Dibayar', 'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
        self::STATUS_PROCESSING => ['label' => 'Diproses', 'badge' => 'bg-teal-100 text-teal-800 border-teal-200'],
        self::STATUS_SHIPPED => ['label' => 'Dikirim', 'badge' => 'bg-sky-100 text-sky-800 border-sky-200'],
        self::STATUS_COMPLETED => ['label' => 'Selesai', 'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
        self::STATUS_CANCELLED => ['label' => 'Dibatalkan', 'badge' => 'bg-rose-100 text-rose-800 border-rose-200'],
    ];

    public const PAYMENT_METHODS = [
        'bank_transfer' => 'Transfer Bank (Virtual Account)',
        'ewallet' => 'QRIS & E-Wallet (GoPay, OVO, Dana)',
        'cod' => 'Bayar di Tempat (COD)',
    ];

    public const PAYMENT_STATUS_META = [
        self::PAYMENT_UNPAID => ['label' => 'Belum Dibayar', 'badge' => 'bg-orange-50 text-orange-700 border-orange-200'],
        self::PAYMENT_PAID => ['label' => 'Lunas', 'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
        self::PAYMENT_REFUNDED => ['label' => 'Dikembalikan', 'badge' => 'bg-rose-100 text-rose-800 border-rose-200'],
    ];

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'notes',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function canBePaid(): bool
    {
        return $this->status === self::STATUS_PENDING
            && $this->payment_status === self::PAYMENT_UNPAID
            && $this->payment_method !== 'cod';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PAID], true);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_META[$this->status]['label'] ?? ucfirst($this->status);
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::STATUS_META[$this->status]['badge'] ?? 'bg-slate-100 text-slate-700 border-slate-200';
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? strtoupper($this->payment_method);
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUS_META[$this->payment_status]['label'] ?? ucfirst($this->payment_status);
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return self::PAYMENT_STATUS_META[$this->payment_status]['badge'] ?? 'bg-slate-100 text-slate-700 border-slate-200';
    }

    public function getFormattedTotalAttribute(): string
    {
        return Money::rupiah($this->total_amount);
    }

    public function getMockVirtualAccountNumberAttribute(): string
    {
        return '8808'.str_pad((string) $this->user_id, 4, '0', STR_PAD_LEFT).str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }
}
