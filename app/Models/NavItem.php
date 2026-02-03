<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'icon',
        'route',
        'order',
        'is_visible',
        'is_active',
        'type',
        'attributes',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_active' => 'boolean',
        'attributes' => 'array',
    ];

    /**
     * Get visible navigation items ordered by their order field
     */
    public static function getVisibleItems()
    {
        return self::where('is_visible', true)
                   ->where('is_active', true)
                   ->orderBy('order')
                   ->get();
    }

    /**
     * Get all navigation items for admin management
     */
    public static function getAllForAdmin()
    {
        return self::orderBy('order')->get();
    }

    /**
     * Update the order of navigation items
     */
    public static function updateOrder(array $itemOrders)
    {
        foreach ($itemOrders as $order => $itemId) {
            self::where('id', $itemId)->update(['order' => $order + 1]);
        }
    }
}
