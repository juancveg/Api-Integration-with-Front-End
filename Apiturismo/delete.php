<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(); }

// Only allow DELETE requests
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

// Use prepared statement to prevent SQL injection
$id   = intval($params->id);
$stmt = $mysqli->prepare('DELETE FROM clientes WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['codigo' => 'ok', 'mensaje' => 'Client deleted']);
} else {
    http_response_code(404);
    echo json_encode(['codigo' => 'error', 'mensaje' => 'No record found with that ID']);
}
