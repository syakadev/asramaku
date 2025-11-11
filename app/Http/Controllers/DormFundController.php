<?php

namespace App\Http\Controllers;

use App\Models\DormFund;
use Illuminate\Http\Request;

class DormFundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DormFund::query();

        // Apply filters
        if ($request->filter_type == 'month') {
            $query->whereMonth('date', $request->month)
                    ->whereYear('date', $request->year);
        } elseif ($request->filter_type == 'range') {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $dormFunds = $query->latest()->get();

        // Calculate statistics
        $totalPemasukan = $dormFunds->where('status', 'pemasukan')->sum('amount');
        $totalPengeluaran = $dormFunds->where('status', 'pengeluaran')->sum('amount');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // Chart data - last 6 months
        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');

            $monthPemasukan = DormFund::where('status', 'pemasukan')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');
            $chartPemasukan[] = $monthPemasukan;

            $monthPengeluaran = DormFund::where('status', 'pengeluaran')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');
            $chartPengeluaran[] = $monthPengeluaran;
        }

        return view('dormfunds.index', compact(
            'dormFunds',
            'totalSaldo',
            'totalPemasukan',
            'totalPengeluaran',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran'
        ));
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
            'amount' => 'required|decimal:0,2',
            'date' => 'required|date',
            'status' => 'required|in:pemasukan,pengeluaran',
            'user_id' => 'required|integer'
        ]);

        DormFund::create($request->all());

        return redirect()->route('dormfunds.index')->with('success', 'Data kas asrama berhasil ditambahkan.');
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
            'amount' => 'required|decimal:0,2',
            'date' => 'required|date',
            'status' => 'required|in:pemasukan,pengeluaran',
            'user_id' => 'required|integer'
        ]);

        $dormfund->update($request->all());

        return redirect()->route('dormfunds.index', $dormfund)->with('success', 'Data kas asrama berhasil diubah.');
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
