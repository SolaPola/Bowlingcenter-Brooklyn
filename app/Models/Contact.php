<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $fillable = [
        'email', 'phoneNumber', 'address', 'isActive', 'note', 'createdAt', 'updatedAt'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'contactId');
    }
}
