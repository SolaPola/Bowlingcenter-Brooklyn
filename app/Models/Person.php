<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    public $timestamps = false;

    protected $fillable = [
        'firstName', 
        'infix', 
        'lastName', 
        'isActive', 
        'note', 
        'createdAt', 
        'updatedAt'
    ];

    // Define relationships
    public function customer()
    {
        return $this->hasOne(Customer::class, 'personId');
    }
    
    public function employee()
    {
        return $this->hasOne(Employee::class, 'personId');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'personId');
    }
}
