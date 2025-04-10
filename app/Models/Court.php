<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reservation;

class Court extends Model
{
    use HasFactory;
    
    protected $table = 'court';

    protected $fillable = [
        'number', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'courtId');
    }
}
