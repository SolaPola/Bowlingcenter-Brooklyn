<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Person;
use App\Models\Score;
use App\Models\Reservation;

class Customer extends Model
{
    use HasFactory;
    
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
