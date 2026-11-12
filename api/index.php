<?php

// Ensure writable directories exist in Vercel's /tmp environment
$storagePath = '/tmp/storage';
$directories = [
    $storagePath,
    $storagePath.'/app',
    $storagePath.'/app/public',
    $storagePath.'/framework',
    $storagePath.'/framework/cache',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
    '/tmp/logs',
];

foreach ($directories as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Forward the request to public/index.php
try {
    require __DIR__.'/../public/index.php';
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "SERVERLESS BOOTSTRAP EXCEPTION:\n";
    echo get_class($e).': '.$e->getMessage()."\n";
    echo 'In '.$e->getFile().':'.$e->getLine()."\n\n";
    echo $e->getTraceAsString();
}
