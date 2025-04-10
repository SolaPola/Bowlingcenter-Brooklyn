<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reservation;

class Order extends Model
{
    use HasFactory;
    
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
