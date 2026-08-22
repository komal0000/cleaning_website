<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testi;
use Illuminate\Support\Facades\DB;

class TestiController extends Controller
{
    public function index()
    {
        $testimonials = Testi::all();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'nullable|string',
            'message' => 'required|string',
            'service' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/testimonials'), $filename);
            $data['photo'] = 'uploads/testimonials/' . $filename;
        }

        Testi::create($data);
        $this->render();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    public function edit(Testi $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testi $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'nullable|string',
            'message' => 'required|string',
            'service' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/testimonials'), $filename);
            $data['photo'] = 'uploads/testimonials/' . $filename;
        }

        $testimonial->update($data);
        $this->render();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testi $testimonial)
    {
        $testimonial->delete();
        $this->render();
        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }
    public function render()
    {
        $testimonials = DB::table('testimonials')->get();
        file_put_contents(resource_path('views/front/components/testimonials/list.blade.php'), view('admin.template.testimonials', compact('testimonials'))->render());
    }
}
