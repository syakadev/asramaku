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
        $dutySchedules = DutySchedule::all();
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
    'duty_id'    => 'required|exists:duties,id',
    'user_id'    => 'required|exists:users,id',
    'start_date' => 'required|date',
    'end_date'   => 'required|date|after:start_date'
    ], [
        // duty_id
        'duty_id.required' => 'Duty wajib dipilih.',
        'duty_id.exists'   => 'Duty yang dipilih tidak valid.',

        // user_id
        'user_id.required' => 'User wajib dipilih.',
        'user_id.exists'   => 'User yang dipilih tidak terdaftar.',

        // start_date
        'start_date.required' => 'Tanggal mulai wajib diisi.',
        'start_date.date'     => 'Tanggal mulai harus berupa format tanggal yang valid.',

        // end_date
        'end_date.required' => 'Tanggal selesai wajib diisi.',
        'end_date.date'     => 'Tanggal selesai harus berupa format tanggal yang valid.',
        'end_date.after'    => 'Tanggal selesai harus lebih besar dari tanggal mulai.',
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
            'duty_id'    => 'required|exists:duties,id',
            'user_id'    => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date'
        ], [
            // duty_id
            'duty_id.required' => 'Duty wajib dipilih.',
            'duty_id.exists'   => 'Duty yang dipilih tidak valid.',

            // user_id
            'user_id.required' => 'User wajib dipilih.',
            'user_id.exists'   => 'User yang dipilih tidak terdaftar.',

            // start_date
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date'     => 'Tanggal mulai harus berupa format tanggal yang valid.',

            // end_date
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.date'     => 'Tanggal selesai harus berupa format tanggal yang valid.',
            'end_date.after'    => 'Tanggal selesai harus lebih besar dari tanggal mulai.',
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
