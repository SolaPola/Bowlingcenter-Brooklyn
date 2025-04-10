<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'personId', 'function', 'department', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class, 'personId');
    }
}
