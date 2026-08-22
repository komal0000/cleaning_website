<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testi;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home()
    {
        $services = Service::orderBy('position')->orderBy('title')->get();

        return view('front.pages.home', compact('services'));
    }

    public function services()
    {
        $services = Service::orderBy('position')->orderBy('title')->get();

        return view('front.pages.services', compact('services'));
    }

    public function gallery(Request $request)
    {
        $services = Service::orderBy('title')->get();

        $query = Gallery::with(['service', 'images'])->where('status', true);

        // Filter by service if provided
        if ($request->has('service') && $request->service != '') {
            $query->where('service_id', $request->service);
        }

        // Filter by featured if provided
        if ($request->has('featured') && $request->featured == '1') {
            $query->where('is_featured', true);
        }

        $galleries = $query->orderBy('position')->orderBy('created_at', 'desc')->paginate(12);

        return view('front.pages.gallery', compact('galleries', 'services'));
    }

    public function galleryDetail($id)
    {
        $gallery = Gallery::with(['service', 'images', 'videos'])->where('status', true)->findOrFail($id);

        return view('front.pages.gallery-detail', compact('gallery'));
    }

    public function team()
    {
        $members = Team::orderBy('created_at')->get();

        return view('front.pages.team', compact('members'));
    }

    public function careers()
    {
        $careers = Career::orderBy('deadline')->get();

        return view('front.pages.career', compact('careers'));
    }

    public function testimonials()
    {
        $testimonials = Testi::latest()->get();

        return view('front.pages.testimonials', compact('testimonials'));
    }
}
