<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\SimpleLoginController;
use Illuminate\Support\Facades\Session;

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create a mock request
$request = Request::create('/login', 'POST', [
    'login' => 'admin',
    'password' => 'password',
]);

// Set the session on the request
$request->setLaravelSession(
    $app->make('Illuminate\Session\Store')
);

// Call the login method
$controller = new SimpleLoginController();
try {
    $response = $controller->login($request);
    if ($response instanceof Illuminate\Http\RedirectResponse) {
        echo "Redirect to: " . $response->getTargetUrl() . "\n";
    } else {
        // If it returns a view or something else, we might have errors
        var_dump($response);
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>