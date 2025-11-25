<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::with('organizer')->latest()->get();
        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('activities.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:0,1',
            'organizer_id' => 'required|exists:users,id',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images', 'public');
            $validatedData['img'] = basename($path);
        }

        Activity::create($validatedData);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $users = User::all();
        return view('activities.edit', compact('activity', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:0,1',
            'organizer_id' => 'required|exists:users,id',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

            if ($request->hasFile('img')) {
                $path = $request->file('img')->store('images', 'public');
                $validatedData['img'] = basename($path);

                if ($activity->img) {
                    Storage::disk('public')->delete('images/' . $activity->img);
                }
            }

        $activity->update($validatedData);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        if ($activity->img) {
            Storage::delete('public/images/' . $activity->img);
        }
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
