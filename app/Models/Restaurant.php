<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function admin(): HasOne
    {
        return $this->hasOne(User::class, 'restaurant_id', 'id')->where('role_id', 2);
    }

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class, 'restaurant_id', 'id');
    }

    public function foods(): HasMany
    {
        return $this->hasMany(Food::class, 'restaurant_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'restaurant_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'restaurant_id', 'id');
    }
}
