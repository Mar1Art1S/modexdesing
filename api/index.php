<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

try {
    // Ensure writable directories exist in Vercel's /tmp environment
    $tmpDirs = [
        '/tmp/views',
        '/tmp/cache',
        '/tmp/sessions',
        '/tmp/logs',
    ];

    foreach ($tmpDirs as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    // Forward the request to public/index.php
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "VERCEL ERROR CAUGHT:\n";
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ':' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}

