<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
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
