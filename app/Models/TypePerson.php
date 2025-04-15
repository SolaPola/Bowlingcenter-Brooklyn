<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypePerson extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'typePerson';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'naam',
        'isActive',
        'note',
        'createdAt',
        'updatedAt'
    ];

    /**
     * Indicates if Laravel should use timestamps.
     * Since we're manually handling createdAt and updatedAt
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = 'createdAt';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = 'updatedAt';

    /**
     * Get the persons with this type.
     */
    public function persons(): HasMany
    {
        return $this->hasMany(Person::class, 'typePerson_id');
    }
}
