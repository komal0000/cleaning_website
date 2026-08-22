<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerApply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CareerApplicationController extends Controller
{
    public function index()
    {
        $applications = CareerApply::latest()->get();
        return view('admin.career-applications.index', compact('applications'));
    }

    public function show(CareerApply $careerApplication)
    {
        return view('admin.career-applications.show', compact('careerApplication'));
    }

    public function destroy(CareerApply $careerApplication)
    {
        if ($careerApplication->resume_path && Storage::disk('public')->exists($careerApplication->resume_path)) {
            Storage::disk('public')->delete($careerApplication->resume_path);
        }

        $careerApplication->delete();
        return redirect()->route('admin.career-applications.index')->with('success', 'Application deleted successfully.');
    }    public function downloadResume(CareerApply $careerApplication)
    {
        if ($careerApplication->resume_path && Storage::disk('public')->exists($careerApplication->resume_path)) {
            $filePath = Storage::disk('public')->path($careerApplication->resume_path);
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'Resume file not found.');
    }
}
