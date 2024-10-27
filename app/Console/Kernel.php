<?php

namespace App\Console;

use App\Models\DetailObat;
use App\Models\Obat;
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
            Log::info('Schedule pengecekan obat dimulai.');
            $detailObats = \App\Models\DetailObat::with('obat')->get();

            foreach ($detailObats as $detailObat) {
                // Ambil merek obat dari relasi dengan model Obat
                $obatName = $detailObat->obat->merek_obat;

                // Cek stok habis
                if ($detailObat->stok_obat <= 0) {
                    event(new \App\Events\MedicineStockEvent('Obat ' . $obatName . ' habis.'));
                    Log::info('Obat ' . $obatName . ' stok habis.');
                }

                // Cek obat hampir kadaluarsa (misalnya dalam 10 hari)
                if ($detailObat->tanggal_kadaluarsa <= now()->addDays(10)) {
                    event(new \App\Events\MedicineStockEvent('Obat ' . $obatName . ' hampir kadaluarsa.'));
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
