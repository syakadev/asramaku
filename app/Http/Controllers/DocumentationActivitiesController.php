<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\documentationActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentationActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Activity $activity)
    {
        return view('documentations.index', compact( 'activity'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activities = Activity::all();
        return view('documentations.create', compact('activities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'activities_id' => 'required|exists:activities,id',
        ]);

            if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images/documentations', 'public');
            $validateData['img'] = basename($path);
        }

        // Gunakan $validatedData['activities_id'] di sini
        $id = $validateData['activities_id'];

        documentationActivities::create($validateData);

        return redirect()->route('documentations',  $id)
            ->with('success', 'Documentation created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(documentationActivities $documentation)
    {
        $id = $documentation->activities_id;
        Storage::delete('public/documentations/' . $documentation->img);
        $documentation->delete();

        return redirect()->route('documentations', $id)
            ->with('success', 'Documentation deleted successfully.');
    }
}

