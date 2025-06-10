<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $histories = Order::where('user_id', Auth::id())  // hanya data user yang login
                     ->where('status', 'paid')         // pastikan status sudah 'paid'
                     ->with(['items.menu', 'user'])   // eager loading relasi
                     ->latest()
                     ->get();

    return view('history.index', compact('histories'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->delete(); // atau logika hapus lainnya

    return redirect()->route('history.index')->with('success', 'Pesanan berhasil dihapus');
}

     public function downloadPdf()
    {
         $user = Auth::user();
    $histories = Order::with(['items.menu', 'user'])
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

    $pdf = Pdf::loadView('history.pdf', compact('histories'))->setPaper('A4', 'portrait');
    return $pdf->download('riwayat_pesanan.pdf');
    }
}
