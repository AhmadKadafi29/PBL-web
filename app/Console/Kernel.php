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
            $medicines = \App\Models\Obat::all();

            foreach ($medicines as $medicine) {
                // Cek stok habis
                if ($medicine->stock <= 0) {
                    event(new \App\Events\MedicineStockEvent('Obat ' . $medicine->name . ' habis.'));
                }

                // Cek obat hampir kadaluarsa (misalnya dalam 30 hari)
                if ($medicine->expiration_date <= now()->addDays(10)) {
                    event(new \App\Events\MedicineStockEvent('Obat ' . $medicine->name . ' hampir kadaluarsa.'));
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
