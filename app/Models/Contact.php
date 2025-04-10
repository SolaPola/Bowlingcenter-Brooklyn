<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Contact extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

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
