<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Total Absensi: " . \App\Models\Absensi::count() . "\n";

$tahunList = \Illuminate\Support\Facades\DB::table('absensi')
    ->selectRaw('YEAR(tanggal) as tahun')
    ->distinct()
    ->orderBy('tahun', 'desc')
    ->pluck('tahun');

echo "Tahun list: " . $tahunList->implode(', ') . "\n";
