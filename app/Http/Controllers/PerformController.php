<?php

namespace App\Http\Controllers;

use App\Models\DutySchedule;
use App\Models\perform;
use App\Models\User;
use Illuminate\Http\Request;

class PerformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $performs = Perform::all();
        return view('performs.index', compact('performs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dutySchedules = DutySchedule::all();
        $users = User::all();
        return view('performs.create', compact('dutySchedules', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|date_format:Y-m-d',
            'status' => 'required|in:dilaksanakan,tidak dilaksanakan',
            'duty_schedule_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);

        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images', 'public');
            $validatedData['img'] = basename($path);
        }

        perform::create($validatedData);

        return redirect()->route('performs.index')->with('success', 'Data piket berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(perform $perform)
    {
        return view('performs.show', compact('perform'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(perform $perform)
    {
        $dutySchedules = DutySchedule::all();
        $users = User::all();
        return view('performs.edit', compact('perform', 'dutySchedules', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, perform $perform)
    {
        $request->validate([
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20',
            'date' => 'nullable|date_format:Y-m-d',
            'status' => 'nullable|in:belum dikerjakan,sudah dikerjakan',
            'duty_schedule_id' => 'nullable|integer',
            'user_id' => 'nullable|integer'
        ]);

        $perform->update($request->all());

        return redirect()->route('performs.index')->with('success', 'Data piket berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(perform $perform)
    {
        $perform->delete();

        return redirect()->route('performs.index')->with('success', 'Data piket berhasil dihapus.');
    }
}
