<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('position')->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'features' => 'nullable|string',
            'position' => 'required|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoFilename = time().'_logo_'.$logoFile->getClientOriginalName();
            $logoFile->move(public_path('uploads/services'), $logoFilename);
            $data['logo'] = 'uploads/services/'.$logoFilename;
        }

        // Handle feature image upload
        if ($request->hasFile('feature_image')) {
            $featureFile = $request->file('feature_image');
            $featureFilename = time().'_feature_'.$featureFile->getClientOriginalName();
            $featureFile->move(public_path('uploads/services'), $featureFilename);
            $data['feature_image'] = 'uploads/services/'.$featureFilename;
        }

        Service::create($data);
        $this->render();

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'features' => 'nullable|string',
            'position' => 'required|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($service->logo && file_exists(public_path($service->logo))) {
                unlink(public_path($service->logo));
            }

            $logoFile = $request->file('logo');
            $logoFilename = time().'_logo_'.$logoFile->getClientOriginalName();
            $logoFile->move(public_path('uploads/services'), $logoFilename);
            $data['logo'] = 'uploads/services/'.$logoFilename;
        }

        // Handle feature image upload
        if ($request->hasFile('feature_image')) {
            // Delete old feature image if exists
            if ($service->feature_image && file_exists(public_path($service->feature_image))) {
                unlink(public_path($service->feature_image));
            }

            $featureFile = $request->file('feature_image');
            $featureFilename = time().'_feature_'.$featureFile->getClientOriginalName();
            $featureFile->move(public_path('uploads/services'), $featureFilename);
            $data['feature_image'] = 'uploads/services/'.$featureFilename;
        }

        $service->update($data);
        $this->render();

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        $this->render();

        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    public function render()
    {
        $services = DB::table('services')->orderBy('position')->get();
        file_put_contents(resource_path('views/front/components/contact/form.blade.php'), view('admin.template.contact.form', compact('services'))->render());
        file_put_contents(resource_path('views/front/components/footer/services.blade.php'), view('admin.template.footer.services', compact('services'))->render());
    }
}
