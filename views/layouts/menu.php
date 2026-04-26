<?php

$role = $_SESSION['user']['role'] ?? 'guest';

if ($role === 'admin') {
    include __DIR__ . '/menu/admin.php';
} elseif ($role === 'user') {
    include __DIR__ . '/menu/user.php';
} else {
    echo '';
}
