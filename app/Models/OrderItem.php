<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'book_id',
        'name',
        'price',
        'quantity',
        'image',
        'author',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    /**
     * Get the total price for this item.
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}