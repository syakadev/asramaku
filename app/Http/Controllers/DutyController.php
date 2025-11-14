<?php

namespace App\Http\Controllers;

use App\Models\Duty;
use Illuminate\Http\Request;

class DutyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $duties = Duty::all();
        return view('duties.index', compact('duties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('duties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'section' => 'required|string',
            'description' => 'required|string'
        ]);

        Duty::create($validate);
        return redirect()->route('duties.index')->with('success', 'Data piket berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Duty $duty)
    {
        $duty = Duty::find($duty->id);
        return view('duties.show', compact('duty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Duty $duty)
    {
        $duty = Duty::find($duty->id);
        return view('duties.edit', compact('duty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Duty $duty)
    {
        $validate = $request->validate([
            'section' => 'required|string',
            'description' => 'required|string'
        ]);

        $duty->update($validate);

        return redirect()->route('duties.index')->with('success', 'Data piket berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Duty $duty)
    {
        $duty->delete();

        $duties = Duty::all();
        return view('duties.index', compact('duties'));
    }
}
