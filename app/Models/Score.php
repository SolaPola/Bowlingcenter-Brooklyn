<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;

class Score extends Model
{
    use HasFactory;
    
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
