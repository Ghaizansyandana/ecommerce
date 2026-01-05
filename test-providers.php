<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Get the service providers from config
$providers = $app->make('config')->get('app.providers');

// Check each provider
foreach ($providers as $provider) {
    if (is_array($provider)) {
        echo "Found array instead of provider class: " . print_r($provider, true) . "\n";
    } elseif (!class_exists($provider)) {
        echo "Provider class does not exist: $provider\n";
    } else {
        echo "OK: $provider\n";
    }
}
