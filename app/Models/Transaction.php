<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'restaurant_id',
        'table_id',
        'status',
        'payment',
        'total',
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

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'id', 'restaurant_id');
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class, 'id', 'table_id');
    }
}
