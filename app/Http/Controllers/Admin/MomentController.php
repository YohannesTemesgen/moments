<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moment;
use App\Models\MomentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MomentController extends Controller
{
    public function create()
    {
        return view('admin.moments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'category' => 'required|string',
            'moment_date' => 'required|date',
            'moment_time' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $moment = Moment::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'category' => $request->category,
            'status' => $request->status ?? 'completed',
            'moment_date' => $request->moment_date,
            'moment_time' => $request->moment_time,
        ]);

        // Debug logging for image upload
        \Log::info('Image upload debug', [
            'has_files' => $request->hasFile('images'),
            'files_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
            'moment_id' => $moment->id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                try {
                    // Generate unique filename
                    $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $publicPath = 'images/' . $filename;
                    
                    // Ensure images directory exists in public folder
                    $imagesDir = public_path('images');
                    if (!file_exists($imagesDir)) {
                        mkdir($imagesDir, 0755, true);
                    }
                    
                    // Move file directly to public directory (works on cPanel)
                    $image->move($imagesDir, $filename);
                    
                    \Log::info('Image stored successfully', [
                        'path' => $publicPath,
                        'original_name' => $filename,
                        'moment_id' => $moment->id,
                    ]);
                    
                    MomentImage::create([
                        'moment_id' => $moment->id,
                        'image_path' => $publicPath,
                        'order' => $index,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed', [
                        'error' => $e->getMessage(),
                        'file' => $image->getClientOriginalName(),
                        'moment_id' => $moment->id,
                    ]);
                    
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['images' => 'Failed to upload image: ' . $image->getClientOriginalName()]);
                }
            }
        }

        return redirect()->route('admin.timeline')->with('success', 'Moment created successfully.');
    }

    public function show(Moment $moment)
    {
        return view('admin.moments.show', compact('moment'));
    }

    public function edit(Moment $moment)
    {
        return view('admin.moments.edit', compact('moment'));
    }

    public function update(Request $request, Moment $moment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'category' => 'required|string',
            'moment_date' => 'required|date',
            'moment_time' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $moment->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'category' => $request->category,
            'status' => $request->status ?? $moment->status,
            'moment_date' => $request->moment_date,
            'moment_time' => $request->moment_time,
        ]);

        // Handle deleted images
        if ($request->has('deleted_images') && is_array($request->deleted_images)) {
            foreach ($request->deleted_images as $imageId) {
                $image = MomentImage::find($imageId);
                if ($image && $image->moment_id == $moment->id) {
                    // Delete the file from public directory
                    $fullPath = public_path($image->image_path);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                    // Delete the database record
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            $maxOrder = $moment->images()->max('order') ?? -1;
            foreach ($request->file('images') as $index => $image) {
                // Generate unique filename
                $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $publicPath = 'images/' . $filename;
                
                // Ensure images directory exists in public folder
                $imagesDir = public_path('images');
                if (!file_exists($imagesDir)) {
                    mkdir($imagesDir, 0755, true);
                }
                
                // Move file directly to public directory (works on cPanel)
                $image->move($imagesDir, $filename);
                
                MomentImage::create([
                    'moment_id' => $moment->id,
                    'image_path' => $publicPath,
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.timeline')->with('success', 'Moment updated successfully.');
    }

    public function destroy(Moment $moment)
    {
        foreach ($moment->images as $image) {
            $fullPath = public_path($image->image_path);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
        $moment->delete();

        return redirect()->route('admin.timeline')->with('success', 'Moment deleted successfully.');
    }

    public function deleteImage(MomentImage $image)
    {
        $fullPath = public_path($image->image_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        $image->delete();

        return response()->json(['success' => true]);
    }
}
