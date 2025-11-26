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
        $documentations = $activity->documentations;
        return view('documentations.index', compact('documentations', 'activity'));
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
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'activities_id' => 'required|exists:activities,id',
        ]);

        $imageName = time().'.'.$request->img->extension();
        $request->img->storeAs('public/documentations', $imageName);

        documentationActivities::create([
            'img' => $imageName,
            'activities_id' => $request->activities_id,
        ]);

        return redirect()->route('documentations.index')
            ->with('success', 'Documentation created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(documentationActivities $documentation)
    {
        Storage::delete('public/documentations/' . $documentation->img);
        $documentation->delete();

        return redirect()->route('documentations.index')
            ->with('success', 'Documentation deleted successfully.');
    }
}

