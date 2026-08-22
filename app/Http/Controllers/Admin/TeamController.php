<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'photo' => 'nullable|image',
            'bio' => 'required|string',
            'experienced' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['photo'] = "uploads/{$filename}";
        }

        Team::create($data);

        return redirect()->route('teams.index')->with('success', 'Team member added.');
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'photo' => 'nullable|image',
            'bio' => 'required|string',
            'experienced' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['photo'] = "uploads/{$filename}";
        }

        $team->update($data);

        return redirect()->back()->with('success', 'Team member updated.');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->back()->with('success', 'Team member deleted.');
    }
}
