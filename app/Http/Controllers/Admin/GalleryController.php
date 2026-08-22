<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\GalleryVideo;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with(['service', 'images', 'videos'])->orderBy('position')->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::orderBy('position')->get();
        return view('admin.galleries.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_videos.*' => 'nullable|url',
            'video_captions.*' => 'nullable|string|max:255',
            'before_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'after_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'before_captions.*' => 'nullable|string|max:255',
            'after_captions.*' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'position' => 'integer|min:0'
        ]);

        $data = $request->only(['service_id', 'title', 'description', 'location', 'completion_date', 'is_featured', 'position', 'status']);

        $gallery = Gallery::create($data);

        // Handle before images
        if ($request->hasFile('before_images')) {
            foreach ($request->file('before_images') as $index => $image) {
                $imageName = time() . '_before_' . $index . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/gallery'), $imageName);

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => 'uploads/gallery/' . $imageName,
                    'image_type' => 'before',
                    'caption' => $request->before_captions[$index] ?? null,
                    'position' => $index
                ]);
            }
        }

        // Handle after images
        if ($request->hasFile('after_images')) {
            foreach ($request->file('after_images') as $index => $image) {
                $imageName = time() . '_after_' . $index . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/gallery'), $imageName);

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => 'uploads/gallery/' . $imageName,
                    'image_type' => 'after',
                    'caption' => $request->after_captions[$index] ?? null,
                    'position' => $index
                ]);
            }
        }

        // Handle YouTube videos
        if ($request->has('youtube_videos')) {
            foreach ($request->youtube_videos as $index => $videoUrl) {
                if (!empty($videoUrl)) {
                    GalleryVideo::create([
                        'gallery_id' => $gallery->id,
                        'video_url' => $videoUrl,
                        'video_type' => 'youtube',
                        'caption' => $request->video_captions[$index] ?? null,
                        'position' => $index
                    ]);
                }
            }
        }

        return redirect()->route('galleries.index')->with('success', 'Gallery item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::with(['service', 'images', 'videos'])->findOrFail($id);
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Gallery::with(['images', 'videos'])->findOrFail($id);
        $services = Service::orderBy('title')->get();
        // dd($gallery->images);
        return view('admin.galleries.edit', compact('gallery', 'services'));
    }    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::with(['images', 'videos'])->findOrFail($id);

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_videos.*' => 'nullable|url',
            'video_captions.*' => 'nullable|string|max:255',
            'before_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'after_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'before_captions.*' => 'nullable|string|max:255',
            'after_captions.*' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'position' => 'integer|min:0',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:gallery_images,id',
            'delete_videos' => 'nullable|array',
            'delete_videos.*' => 'exists:gallery_videos,id'
        ]);

        $data = $request->only(['service_id', 'title', 'description', 'location', 'completion_date', 'is_featured', 'position', 'status']);
        $gallery->update($data);

        // Handle image deletions
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = GalleryImage::find($imageId);
                if ($image && $image->gallery_id == $gallery->id) {
                    // Delete physical file
                    if (file_exists(public_path($image->image_path))) {
                        unlink(public_path($image->image_path));
                    }
                    $image->delete();
                }
            }
        }

        // Handle video deletions
        if ($request->has('delete_videos')) {
            foreach ($request->delete_videos as $videoId) {
                $video = GalleryVideo::find($videoId);
                if ($video && $video->gallery_id == $gallery->id) {
                    $video->delete();
                }
            }
        }

        // Handle new before images
        if ($request->hasFile('before_images')) {
            $maxPosition = $gallery->beforeImages()->max('position') ?? -1;
            foreach ($request->file('before_images') as $index => $image) {
                $imageName = time() . '_before_' . ($maxPosition + $index + 1) . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/gallery'), $imageName);

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => 'uploads/gallery/' . $imageName,
                    'image_type' => 'before',
                    'caption' => $request->before_captions[$index] ?? null,
                    'position' => $maxPosition + $index + 1
                ]);
            }
        }

        // Handle new after images
        if ($request->hasFile('after_images')) {
            $maxPosition = $gallery->afterImages()->max('position') ?? -1;
            foreach ($request->file('after_images') as $index => $image) {
                $imageName = time() . '_after_' . ($maxPosition + $index + 1) . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/gallery'), $imageName);

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => 'uploads/gallery/' . $imageName,
                    'image_type' => 'after',
                    'caption' => $request->after_captions[$index] ?? null,
                    'position' => $maxPosition + $index + 1
                ]);
            }
        }

        // Handle new YouTube videos
        if ($request->has('youtube_videos')) {
            $maxPosition = $gallery->videos()->max('position') ?? -1;
            foreach ($request->youtube_videos as $index => $videoUrl) {
                if (!empty($videoUrl)) {
                    GalleryVideo::create([
                        'gallery_id' => $gallery->id,
                        'video_url' => $videoUrl,
                        'video_type' => 'youtube',
                        'caption' => $request->video_captions[$index] ?? null,
                        'position' => $maxPosition + $index + 1
                    ]);
                }
            }
        }

        return redirect()->route('galleries.index')->with('success', 'Gallery item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::with('images')->findOrFail($id);

        // Delete all associated images
        foreach ($gallery->images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }

        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Gallery item deleted successfully.');
    }
}
