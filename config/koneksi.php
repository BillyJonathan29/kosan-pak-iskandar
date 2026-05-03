<?php
// Base URL Aplikasi
define('BASEURL', 'http://localhost/kosan/public');


// Kredensial Database
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'kos-kosan');

// Kredensial Midtrans
define('MIDTRANS_SERVER_KEY', $_ENV['MIDTRANS_SERVER_KEY'] ?? '');
define('MIDTRANS_CLIENT_KEY', $_ENV['MIDTRANS_CLIENT_KEY'] ?? '');
define('MIDTRANS_IS_PRODUCTION', filter_var($_ENV['MIDTRANS_IS_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN));
define('MIDTRANS_IS_SANITIZED', true);
define('MIDTRANS_IS_3DS', true);

// Kredensial Google Auth
define('GOOGLE_CLIENT_ID', $_ENV['GOOGLE_CLIENT_ID'] ?? '');
define('GOOGLE_CLIENT_SECRET', $_ENV['GOOGLE_CLIENT_SECRET'] ?? '');
define('GOOGLE_REDIRECT_URI', BASEURL . '/auth/callback');
