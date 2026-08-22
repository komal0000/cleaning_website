<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Career;
use Illuminate\Support\Facades\DB;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::all();
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('admin.careers.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'description' => 'required|string',
            'type' => 'nullable|string',
            'deadline' => 'nullable|date',
            'requirement' => 'nullable|string',
        ]);

        Career::create($data);
        $this->render();
        return redirect()->route('careers.index')->with('success', 'Career opportunity added.');
    }

    public function edit(Career $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, $career)
    {
        // dd($request->all());
        $career = Career::where('id', $career)->first();
        $career->title = $request->title;
        $career->location = $request->location;
        $career->description = $request->description;
        $career->deadline = $request->deadline;
        $career->requirement = $request->requirement;
        $career->save();
        $this->render();
        return redirect()->route('careers.index')->with('success', 'Career updated.');
    }

    public function destroy(Career $career)
    {
        $career->delete();
        $this->render();
        return redirect()->back()->with('success', 'Career deleted.');
    }

    public function render() {
        $careers = DB::table('careers')->get();
        file_put_contents(resource_path('views/front/components/career/main.blade.php'), view('admin.template.careers', compact('careers'))->render());
    }
}
