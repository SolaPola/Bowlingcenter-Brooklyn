<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'person';

    protected $fillable = [
        'firstName', 'infix', 'lastName', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'personId');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'personId');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'personId');
    }
}
