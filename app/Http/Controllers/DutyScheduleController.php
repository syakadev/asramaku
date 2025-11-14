<?php

namespace App\Http\Controllers;

use App\Models\Duty;
use App\Models\DutySchedule;
use App\Models\User;
use Illuminate\Http\Request;

class DutyScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dutySchedules = DutySchedule::with(['duty', 'user'])->get();
        return view('dutySchedules.index', compact('dutySchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $duties = Duty::all();
        return view('dutySchedules.create', compact('users', 'duties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'duty_id' => 'required|exists:duties,id',
            'user_id' => 'required|exists:users,id',
            'period' => 'required|string',
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
        $users = User::all();
        $duties = Duty::all();
        return view('dutySchedules.edit', compact('dutySchedule', 'users', 'duties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DutySchedule $dutySchedule)
    {
        $request->validate([
            'duty_id' => 'required|exists:duties,id',
            'user_id' => 'required|exists:users,id',
            'period' => 'required|string',
        ]);

        $dutySchedule->update($request->all());

        return redirect()->route('dutySchedules.index')->with('success', 'Data piket berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DutySchedule $dutySchedule)
    {
        $dutySchedule->delete();
        return redirect()->route('dutySchedules.index')->with('success', 'Data piket berhasil dihapus.');
    }
}
