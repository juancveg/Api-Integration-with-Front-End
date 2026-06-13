<?php
// Database connection — credentials can be overridden via environment variables
$host     = getenv('DB_HOST')     ?: 'localhost';
$user     = getenv('DB_USER')     ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME')     ?: 'turismo';

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode([
        'codigo'  => 'error',
        'mensaje' => 'Database connection failed: ' . $mysqli->connect_error,
    ]);
    exit();
}

$mysqli->set_charset('utf8mb4');
