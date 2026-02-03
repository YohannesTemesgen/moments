<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class MomentImage extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'moment_id',
        'image_path',
        'order',
    ];

    protected $appends = ['url'];

    public function moment(): BelongsTo
    {
        return $this->belongsTo(Moment::class);
    }

    /**
     * Get the full URL for the image
     * This works in both local and production environments
     * Uses public directory instead of storage disk
     */
    public function getUrlAttribute(): string
    {
        // Normalize path - remove any leading slashes
        $path = ltrim($this->image_path, '/');
        
        // Use asset() helper to generate proper public directory URLs
        return asset($path);
    }
}
