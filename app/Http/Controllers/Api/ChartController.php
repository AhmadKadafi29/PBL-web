<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function weeklyChart()
    {
        $weeklyData = Penjualan::selectRaw('YEAR(tanggal) as year, WEEK(tanggal) as week, SUM(jumlah) as total')
            ->groupBy('year', 'week')
            ->orderBy('year', 'ASC')
            ->orderBy('week', 'ASC')
            ->get();

        $labels = [];
        $data = [];

        foreach ($weeklyData as $item) {
            $labels[] = "Week " . $item->week . ' ' . $item->year;
            $data[] = $item->total;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function monthlyChart()
    {
        $monthlyData = Penjualan::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, SUM(jumlah) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'ASC')
            ->orderBy('month', 'ASC')
            ->get();

        $labels = [];
        $data = [];

        foreach ($monthlyData as $item) {
            $labels[] = Carbon::createFromDate($item->year, $item->month, 1)->format('F Y');
            $data[] = $item->total;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
