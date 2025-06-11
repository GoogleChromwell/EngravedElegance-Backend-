<?php
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
$localhost = $_SERVER['HTTP_HOST'] === 'localhost';

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => $secure,
    'httponly' => true,
    'samesite' => $localhost ? 'Lax' : 'None'
]);
session_start();

$allowed_origins = [
    'http://localhost:5173',
    'https://engraved-elegance-frontend.vercel.app'
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
}

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
}

if (isset($_SESSION["user"])) {
    echo json_encode([
        "loggedIn" => true,
        "email" => $_SESSION["user"]["email"],
        "role" => $_SESSION["user"]["role"],
        "first_name" => $_SESSION["user"]["first_name"],
        "last_name" => $_SESSION["user"]["last_name"],
    ]);
} else {
    echo json_encode(["loggedIn" => false]);
}
