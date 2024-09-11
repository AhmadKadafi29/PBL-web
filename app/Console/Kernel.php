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
            $lowStock = Obat::where('stok_obat', '<=', 10)->get();
            $expiringSoon = Obat::where('tanggal_kadaluarsa', '<=', now()->addDays(7))->get();

            $notifications = [
                'lowStock' => $lowStock,
                'expiredSoon' => $expiringSoon,
            ];

            file_put_contents(storage_path('app/public/notifications.json'), json_encode($notifications));
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
