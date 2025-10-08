<?php

namespace App\Http\Controllers;

use App\Models\Infraction;
use Illuminate\Http\Request;

class InfractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infraction = Infraction::all();
        return view('infractions.index', compact('infraction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  view('infractions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required|string',
            'note' => 'nullable|string',
            'type' => 'required|in:piket,kerapian dan kebersihan',
            'status' => 'required|in:dibayar,belum dibayar',
            'reporter_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);


        Infraction::create($request->all());

        return redirect()->route('infractions.index')->with('success', 'Data kas asrama berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Infraction $infraction)
    {
        return view('infractions.show', compact('infraction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infraction $infraction)
    {
        return view('infractions.edit', compact('infraction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Infraction $infraction)
    {
        $request->validate([
            'img' => 'required|string',
            'note' => 'nullable|string',
            'type' => 'required|in:piket,kerapian dan kebersihan',
            'status' => 'required|in:dibayar,belum dibayar',
            'reporter_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);

        $infraction->update($request->all());

        return redirect()->route('infractions.edit', $infraction)->with('success', 'Data pelanggaran berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infraction $infraction)
    {
        $infraction->delete();
        return redirect()->route('infractions.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
