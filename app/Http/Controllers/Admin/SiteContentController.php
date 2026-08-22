<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\SiteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();

        return view('admin.settings.site-content', [
            'setting' => $setting,
            'content' => SiteContent::resolve($setting),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate(['content_json' => ['required', 'json']]);
        $content = json_decode($request->string('content_json')->toString(), true, 512, JSON_THROW_ON_ERROR);

        validator($content, [
            'global.navigation' => ['nullable', 'array'],
            'global.navigation.*.route' => ['nullable', 'in:home,services,about,team,gallery,career,testimonials,contact'],
            'global.navigation.*.label' => ['nullable', 'string', 'max:60'],
        ])->validate();

        $setting = Setting::firstOrNew();
        $setting->site_content = $content;
        $setting->save();

        return back()->with('success', 'Public site content updated successfully.');
    }

    public function upload(Request $request): JsonResponse
    {
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        $path = $request->file('image')->store('uploads/site-content', 'public');

        return response()->json(['path' => 'storage/'.$path]);
    }
}
