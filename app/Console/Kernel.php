<?php

namespace App\Console;

use App\Models\DetailObat;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $lowStockObat = DetailObat::where('stok_obat', '<', 10)->get();
            $expiredSoonObat = DetailObat::where('tanggal_kadaluarsa', '<', Carbon::now()->addDays(7))->get();

            if ($lowStockObat->isNotEmpty() || $expiredSoonObat->isNotEmpty()) {
                // Tambahkan notifikasi atau tindakan lain di sini
                if ($lowStockObat->isNotEmpty()) {
                    Log::info('Stok obat hampir habis:');
                    foreach ($lowStockObat as $obat) {
                        Log::info('Stok obat ' . $obat->obat->merek_obat . ' hampir habis. Stok tersisa: ' . $obat->stok_obat);
                    }
                }

                if ($expiredSoonObat->isNotEmpty()) {
                    Log::info('Obat hampir kadaluarsa:');
                    foreach ($expiredSoonObat as $obat) {
                        Log::info('Obat ' . $obat->obat->merek_obat . ' akan segera kadaluarsa pada ' . $obat->tanggal_kadaluarsa->format('d-m-Y'));
                    }
                }
            }

        })->everyMinute();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
