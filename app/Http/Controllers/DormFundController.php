<?php

namespace App\Http\Controllers;

use App\Models\DormFund;
use Illuminate\Http\Request;

class DormFundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dormFunds = DormFund::all();
        return view('dormfunds.index', compact('dormFunds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dormfunds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'balance' => 'required|decimal',
            'date' => 'required|date',
            'status' => 'required|in:pemasukan,pengeluaran',
            'user_id' => 'required|integer'
        ]);

        if ($request->fails()) {
            return view('dormfunds.create', compact($request->errors()));
        }

        DormFund::create($request->all());

        return redirect()->route('dormfunds.index')->with('success', 'Data kas asrama berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(DormFund $dormFund)
    {
        return view('dormfunds.show', compact('dormFund'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DormFund $dormFund)
    {
        return view('dormfunds.edit', compact('dormFund'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DormFund $dormFund)
    {
        $request->validate([
            'title' => 'required|string',
            'balance' => 'required|decimal',
            'date' => 'required|date',
            'status' => 'required|in:pemasukan,pengeluaran',
            'user_id' => 'required|integer'
        ]);

        $dormFund->update($request->all());

        return redirect()->route('dormfunds.index')->with('success', 'Data kas asrama berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DormFund $dormFund)
    {
        $dormFund->delete();
        return redirect()->route('dormfunds.index')->with('success', 'Data kas asrama berhasil dihapus.');

    }
}
