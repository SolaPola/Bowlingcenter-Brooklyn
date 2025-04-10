<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'reservationId', 'orderNumber', 'orderDate',
        'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservationId');
    }
}
