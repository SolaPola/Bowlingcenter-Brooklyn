<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reservation;

class Timeslot extends Model
{
    use HasFactory;
    
    protected $table = 'timeslot';

    protected $fillable = [
        'startTime', 'endTime', 'day', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'timeslotId');
    }
}
