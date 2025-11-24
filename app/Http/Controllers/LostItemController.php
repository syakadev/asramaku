<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LostItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lostItems = LostItem::all();
        return view('lostitems.index', compact('lostItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lostitems.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_found' => 'required|date',
            'date_taken' => 'nullable|date',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:found,taken',
            'reporter_id' => 'required|integer',
            'user_id' => 'nullable|integer',
        ]);

        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images', 'public');
            $validatedData['img'] = basename($path);
        }

        LostItem::create($validatedData);

        return redirect()->route('lostitems.index')->with('success', 'Data barang hilang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
        public function show(LostItem $lostitem)
        {
            return view('lostitems.show', compact('lostitem'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(LostItem $lostitem)
        {
            return view('lostitems.edit', compact('lostitem'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, LostItem $lostitem)
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date_found' => 'required|date',
                'date_taken' => 'nullable|date',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status' => 'required|in:found,taken',
                'reporter_id' => 'required|integer',
                'user_id' => 'nullable|integer',
            ]);

            if ($request->hasFile('img')) {
                $path = $request->file('img')->store('images', 'public');
                $validatedData['img'] = basename($path);

                if ($lostitem->img) {
                    Storage::disk('public')->delete('images/' . $lostitem->img);
                }
            }

            $lostitem->update($validatedData);

            return redirect()->route('lostitems.index')->with('success', 'Data barang hilang berhasil diubah.');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(LostItem $lostitem)
        {
            if ($lostitem->img) {
                Storage::disk('public')->delete('images/' . $lostitem->img);
            }

            $lostitem->delete();

            return redirect()->route('lostitems.index')->with('success', 'Data barang hilang berhasil dihapus.');
        }}
