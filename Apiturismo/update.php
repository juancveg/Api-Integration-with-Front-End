<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(); }

// Only allow PUT requests
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['codigo' => 'error', 'mensaje' => 'Method not allowed']);
    exit();
}

include('conexion.php');

$json   = file_get_contents('php://input');
$params = json_decode($json);

if (empty($params->id)) {
    http_response_code(400);
    echo json_encode(['codigo' => 'error', 'mensaje' => 'Missing required field: id']);
    exit();
}

$id        = intval($params->id);
$nombres   = trim($params->nombres   ?? '');
$apellidos = trim($params->apellidos ?? '');
$direccion = trim($params->direccion ?? '');
$telefono  = trim($params->telefono  ?? '');
$correo    = trim($params->correo    ?? '');
$now       = date('Y-m-d H:i:s');

$sql  = 'UPDATE clientes SET nombres=?, apellidos=?, direccion=?, telefono=?, correo=?, modified=? WHERE id=?';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ssssssi', $nombres, $apellidos, $direccion, $telefono, $correo, $now, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['codigo' => 'ok', 'mensaje' => 'Client updated']);
} else {
    http_response_code(404);
    echo json_encode(['codigo' => 'error', 'mensaje' => 'No record updated — check the ID']);
}
