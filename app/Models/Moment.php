<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Moment extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'latitude',
        'longitude',
        'category',
        'status',
        'moment_date',
        'moment_time',
    ];

    protected $casts = [
        'moment_date' => 'date',
        'moment_time' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(MomentImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->images()->first();
    }
}
