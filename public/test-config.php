<?php
// Simple test to check current configuration values
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

header('Content-Type: text/plain');

echo "=== LIVE CONFIGURATION TEST ===\n";
echo "APP_URL: " . config('app.url') . "\n";
echo "APP_ENV: " . config('app.env') . "\n";
echo "APP_DEBUG: " . (config('app.debug') ? 'true' : 'false') . "\n";
echo "Storage URL: " . Storage::disk('public')->url('') . "\n";
echo "Asset URL: " . asset('') . "\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n";
