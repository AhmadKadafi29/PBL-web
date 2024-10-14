<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahObat = Obat::count();
        $jumlahSupplier = Supplier::count();
        $jumlahPenjualan = Penjualan::count();
        // $jumlahPenjualan = Penjualan::sum('total_harga');
        // $totalPengeluaran = Pembelian::sum('total_harga');
        // $salesData = Penjualan::orderBy('created_at')->get();
        // $chartData = $salesData->groupBy(function ($date) {
        //     return $date->created_at->format('d M');
        // })->map(function ($group) {
        //     return $group->sum('total_amount');
        // });

        return view('pages.app.dashboard', compact('jumlahObat', 'jumlahSupplier', 'jumlahPenjualan'));
    }

    public function chart()
    {
        $salesData = Penjualan::orderBy('created_at')->get();
        $chartData = $salesData->groupBy(function ($date) {
            return $date->created_at->format('d M');
        })->map(function ($group) {
            return $group->sum('total_amount');
        });

        return response()->json($chartData);
    }
}

