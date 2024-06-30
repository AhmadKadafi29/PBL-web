<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $lowStockObat = DetailObat::where('stok_obat', '<', 10)->get();
        $expiredSoonObat = DetailObat::where('tanggal_kadaluarsa', '<', Carbon::now()->addDays(7))->get();

        return [
            'lowStock' => $lowStockObat,
            'expiredSoon' => $expiredSoonObat,
        ];
    }
}
