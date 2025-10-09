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
        $infractions = Infraction::all();
        return view('infractions.index', compact('infractions'));
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
        // 1. Validasi input
        $validatedData = $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'note' => 'nullable|string',
            'type' => 'required|in:piket,kerapian dan kebersihan',
            'reporter_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);

        // 2. Proses upload gambar dan dapatkan path-nya
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images', 'public');
            $validatedData['img'] = basename($path);
        }

        Infraction::create($validatedData);
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
        $validatedData = $request->validate([
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'note' => 'nullable|string',
            'type' => 'required|in:piket,kerapian dan kebersihan',
            'reporter_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);

        // Cek apakah ada file gambar baru yang di-upload
        if ($request->hasFile('img')) {
            // Simpan gambar baru
            $path = $request->file('img')->store('images', 'public');
            $validatedData['img'] = basename($path);

            // Opsional: Hapus gambar lama jika ada untuk menghemat storage
            if ($infraction->img) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('images/' . $infraction->img);
            }
        }

        // Update data di database
        $infraction->update($validatedData);

        return redirect()->route('infractions.index')->with('success', 'Data pelanggaran berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infraction $infraction)
    {
        $infraction->delete();
        return redirect()->route('infractions.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }

    /**
     * Update the status of the specified resource to 'paid'.
     */
    public function updateStatus(Infraction $infraction)
    {
        // Update status menjadi 'dibayar'
        $infraction->status = 'dibayar';
        $infraction->save();

        return redirect()->route('infractions.index')->with('success', 'Status pelanggaran berhasil diubah menjadi Dibayar.');
    }
}
