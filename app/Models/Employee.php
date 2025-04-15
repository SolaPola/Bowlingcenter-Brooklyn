<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Employee extends Model
{
    use HasFactory;
    
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
