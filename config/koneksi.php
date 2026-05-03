<?php
// Base URL Aplikasi
define('BASEURL', 'http://localhost/kosan/public');

// Kredensial Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'kos-kosan');
// Kredensial Midtrans
define('MIDTRANS_SERVER_KEY', 'Mid-server-UhSCwvrjDQ42YiAfMQ1yxVFx');
define('MIDTRANS_CLIENT_KEY', 'Mid-client-ggfBPX9ZNph3qwmJ');
define('MIDTRANS_IS_PRODUCTION', false);
define('MIDTRANS_IS_SANITIZED', true);
define('MIDTRANS_IS_3DS', true);


// kredentials auth
define('GOOGLE_CLIENT_ID', '771837956034-94t76qi6llhv90m0ciealk6mei63mesu.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', BASEURL . '/auth/callback');
