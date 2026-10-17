<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\SimpleLoginController;

// Create a mock request
$request = new Request([
    'login' => 'admin',
    'password' => 'password',
]);

// Call the login method
$controller = new SimpleLoginController();
$response = $controller->login($request);

// If it returns a redirect, we can check the target
if ($response instanceof Illuminate\Http\RedirectResponse) {
    echo "Redirect to: " . $response->getTargetUrl() . "\n";
} else {
    // If it returns a view or something else, we might have errors
    var_dump($response);
}
?>