<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Duty extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'section',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // /**
    //  * Get the parent that owns the Duty
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(Parent::class, 'foreign_key', 'owner_key');
    // }

    // /**
    //  * Get all of the children for the Duty
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function children(): HasMany
    // {
    //     return $this->hasMany(Child::class, 'foreign_key', 'local_key');
    // }
    public function dutySchedule()
    {
        return $this->hasMany(DutySchedule::class, 'duty_id', 'id');
    }
}
