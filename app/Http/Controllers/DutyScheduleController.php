<?php

namespace App\Http\Controllers;

use App\Models\DutySchedule;
use Illuminate\Http\Request;

class DutyScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        DutySchedule::all();
        return view('dutySchedules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dutySchedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'duty_id',
            'user_id',
            'period'
        ]);

        DutySchedule::create($request->all());
        return redirect()->route('dutySchedules.index')->with('success', 'Data piket berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DutySchedule $dutySchedule)
    {
        return view('dutySchedules.show', compact('dutySchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DutySchedule $dutySchedule)
    {
        return view('dutySchedules.edit', compact('dutySchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DutySchedule $dutySchedule)
    {
        $request->validate([
            'duty_id',
            'user_id',
            'period'
        ]);

        $dutySchedule->update($request->all());

        return redirect('dutySchedules.index')->with('success', 'Data piket berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DutySchedule $dutySchedule)
    {
        $dutySchedule->delete();
        return redirect('dutySchedules.index')->with('success', 'Data piket berhasil dihapus.');
    }
}
