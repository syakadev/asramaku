<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DormFund extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'note',
        'amount',
        'date',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // /**
    //  * Get the parent that owns the DormFund
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(Parent::class, 'foreign_key', 'owner_key');
    // }

    // /**
    //  * Get all of the children for the DormFund
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function children(): HasMany
    // {
    //     return $this->hasMany(Child::class, 'foreign_key', 'local_key');
    // }
}
