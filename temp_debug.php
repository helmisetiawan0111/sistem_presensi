<?php
// Quick DB check
$app = require 'D:/PROJEK BOSS/sistem-presensi/sistem-presensi/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Absensi;
use Carbon\Carbon;

$today = Carbon::now()->toDateString();
echo "Today: $today\n";

// Try both queries
$q1 = Absensi::where('tanggal', $today);
$c1 = $q1->count();
echo "where('tanggal', today) count: $c1\n";

$q2 = Absensi::whereDate('tanggal', $today);
$c2 = $q2->count();
echo "whereDate('tanggal', today) count: $c2\n";

if ($c2 > 0) {
    $absensi = $q2->with('santri')->get();
    echo "\nRecords:\n";
    foreach ($absensi as $ab) {
        $st = strtolower($ab->status ?? '');
        echo "  id={$ab->id} sid={$ab->santri_id} st=[$st] nm={$ab->santri?->nama}\n";
    }
}
