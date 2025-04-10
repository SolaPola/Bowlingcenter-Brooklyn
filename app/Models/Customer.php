<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    public $timestamps = false;

    protected $fillable = [
        'personId',
        'scoreId',
        'membershipType',
        'isActive',
        'note',
        'createdAt',
        'updatedAt'
    ];

    // Define relationships
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

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'customerId');
    }
}
