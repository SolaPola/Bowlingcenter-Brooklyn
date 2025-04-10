<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
        'personId', 'scoreId', 'membershipType', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class, 'personId');
    }

    public function score()
    {
        return $this->belongsTo(Score::class, 'scoreId');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'customerId');
    }
}
