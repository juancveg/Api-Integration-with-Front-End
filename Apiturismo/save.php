<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(); }

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['codigo' => 'error', 'mensaje' => 'Method not allowed']);
    exit();
}

include('conexion.php');

$json   = file_get_contents('php://input');
$params = json_decode($json);

// Validate required fields
$required = ['nombres', 'apellidos', 'correo'];
foreach ($required as $field) {
    if (empty($params->$field)) {
        http_response_code(400);
        echo json_encode(['codigo' => 'error', 'mensaje' => "Missing required field: $field"]);
        exit();
    }
}

$nombres   = trim($params->nombres);
$apellidos = trim($params->apellidos);
$direccion = trim($params->direccion ?? '');
$telefono  = trim($params->telefono  ?? '');
$correo    = trim($params->correo);
$now       = date('Y-m-d H:i:s');

$sql  = 'INSERT INTO clientes (nombres, apellidos, direccion, telefono, correo, created, modified)
         VALUES (?, ?, ?, ?, ?, ?, ?)';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('sssssss', $nombres, $apellidos, $direccion, $telefono, $correo, $now, $now);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    http_response_code(201);
    echo json_encode(['codigo' => 'ok', 'mensaje' => 'Client created', 'id' => $mysqli->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['codigo' => 'error', 'mensaje' => 'Could not save the record']);
}
