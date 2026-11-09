<?php

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
