<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use App\Models\Reservation;
use App\Models\Score;

class Spel extends Model
{
    /** @use HasFactory<\Database\Factories\SpelFactory> */
    use HasFactory;

    protected $table = 'spel';

    protected $fillable = [
        'personId',
        'reservationId',
        'isActive',
        'note',
        'createdAt',
        'updatedAt'
    ];

    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class, 'personId');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservationId');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'spelId');
    }
}
