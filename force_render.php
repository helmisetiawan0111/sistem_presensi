<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\View;
use App\Models\Absensi;
use App\Models\Santri;
use Carbon\Carbon;

$today = Carbon::now()->toDateString();
$absensiHariIni = Absensi::with('santri')->whereDate('tanggal', $today)->get();

$view = View::make('admin.dashboard', compact('absensiHariIni'));
echo $view->render();
