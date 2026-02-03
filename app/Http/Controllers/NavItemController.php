<?php

namespace App\Http\Controllers;

use App\Models\NavItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NavItemController extends Controller
{
    /**
     * Display the navigation management page
     */
    public function index()
    {
        $navItems = NavItem::getAllForAdmin();
        return view('admin.navigation', compact('navItems'));
    }

    /**
     * Update the visibility of a navigation item
     */
    public function updateVisibility(Request $request, NavItem $navItem): JsonResponse
    {
        $request->validate([
            'is_visible' => 'required|boolean'
        ]);

        $navItem->update([
            'is_visible' => $request->is_visible
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Navigation item visibility updated successfully'
        ]);
    }

    /**
     * Update the order of navigation items
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'integer|exists:nav_items,id'
        ]);

        NavItem::updateOrder($request->items);

        return response()->json([
            'success' => true,
            'message' => 'Navigation order updated successfully'
        ]);
    }

    /**
     * Update a navigation item
     */
    public function update(Request $request, NavItem $navItem): JsonResponse
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'type' => 'required|in:link,button,divider',
            'attributes' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        $navItem->update($request->only([
            'label', 'icon', 'route', 'type', 'attributes', 'is_active'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Navigation item updated successfully'
        ]);
    }

    /**
     * Create a new navigation item
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:nav_items,name',
            'label' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'type' => 'required|in:link,button,divider',
            'attributes' => 'nullable|array'
        ]);

        $maxOrder = NavItem::max('order') ?? 0;

        $navItem = NavItem::create([
            'name' => $request->name,
            'label' => $request->label,
            'icon' => $request->icon,
            'route' => $request->route,
            'type' => $request->type,
            'attributes' => $request->attributes,
            'order' => $maxOrder + 1,
            'is_visible' => true,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Navigation item created successfully',
            'item' => $navItem
        ]);
    }

    /**
     * Delete a navigation item
     */
    public function destroy(NavItem $navItem): JsonResponse
    {
        $navItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Navigation item deleted successfully'
        ]);
    }
}
