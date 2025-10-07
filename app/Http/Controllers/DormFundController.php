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
            'note' => 'nullable|string',
            'balance' => 'required|decimal:0,2',
            'date' => 'required|date',
            'status' => 'required|in:pemasukan,pengeluaran',
            'user_id' => 'required|integer'
        ]);

        DormFund::create($request->all());

        return redirect()->route('dormfunds.index')->with('success', 'Data kas asrama berhasil ditambahkan.');


        // backend massage
        // // Kembalikan respons sukses yang proper
        // return response()->json(['message' => 'Data berhasil dibuat'], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(DormFund $dormfund)
    {
        return view('dormfunds.show', compact('dormfund'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DormFund $dormfund)
    {
        return view('dormfunds.edit', compact('dormfund'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DormFund $dormfund)
    {

        $request->validate([
            'title' => 'required|string',
            'balance' => 'required|decimal:0,2',
            'date' => 'required|date',
            'status' => 'required|in:pemasukan,pengeluaran',
            'user_id' => 'required|integer'
        ]);

        $dormfund->update($request->all());

        return redirect()->route('dormfunds.edit')->with('success', 'Data kas asrama berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DormFund $dormfund)
    {
        $dormfund->delete();
        return redirect()->route('dormfunds.index')->with('success', 'Data kas asrama berhasil dihapus.');
    }

}
