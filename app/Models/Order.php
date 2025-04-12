<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_name',
        'date',
        'price',
        'platform',
        'quantity',
        'total',
        'product_id',
        'gencode',
        'name',
        'adress',
        'country',
        'tracking_number',
        'tracking_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'date' => 'date',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
        'tracking_number' => 'string',
        'tracking_url' => 'string',
        'name' => 'string',
        'adress' => 'string',
        'country' => 'string',
        'gencode' => 'string',
        'product_id' => 'integer',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'status' => OrderStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'date',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
        'tracking_number' => 'string',
        'tracking_url' => 'string',
        'name' => 'string',
        'adress' => 'string',
        'country' => 'string',
        'gencode' => 'string',
        'product_id' => 'integer',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
