<?php
session_start();

$kullanicilar = [
    'Cansu' => [
        'password' => 'second123',
        'full_name' => 'Cansu Güneş',
        'email' => 'cansu@second.com'
    ],
    'demo' => [
        'password' => 'demo123',
        'full_name' => 'Demo Kullanıcı',
        'email' => 'demo@second.com'
    ]
];

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function viewed_devices(): array
{
    if (empty($_COOKIE['viewed_devices'])) {
        return [];
    }

    $decoded = json_decode($_COOKIE['viewed_devices'], true);

    return is_array($decoded) ? $decoded : [];
}
