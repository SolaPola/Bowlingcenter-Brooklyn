<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';

    protected $fillable = [
        'amount', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function customers()
    {
        return $this->hasMany(Customer::class, 'scoreId');
    }
}
