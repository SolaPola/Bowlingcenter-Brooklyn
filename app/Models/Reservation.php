<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';

    protected $fillable = [
        'customerId', 'timeslotId', 'courtId', 'date', 'minutes',
        'status', 'numberOfPeople', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class, 'timeslotId');
    }

    public function court()
    {
        return $this->belongsTo(Court::class, 'courtId');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'reservationId');
    }
}
