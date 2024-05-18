<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property OrderStatus $status
 * @method created_at()
 * @method static create(array $array)
 */
class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'status',
        'price'
    ];


    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function olderThan(int $minutes): bool
    {
        return $this->created_at()->diffInMinutes(now()) > $minutes;
    }

    public function markAsCanceled(): void
    {
        $this->update([
            'status' => OrderStatus::CANCELLED,
        ]);
    }


}
