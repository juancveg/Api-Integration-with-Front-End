<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['codigo' => 'error', 'mensaje' => 'Method not allowed']);
    exit();
}

include('conexion.php');

// Read optional JSON body (to filter by ID)
$json   = file_get_contents('php://input');
$params = $json ? json_decode($json) : null;

if (isset($params->id)) {
    // Fetch single client by ID — use prepared statement to prevent SQL injection
    $id   = intval($params->id);
    $stmt = $mysqli->prepare('SELECT * FROM clientes WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch all clients
    $result = $mysqli->query('SELECT * FROM clientes ORDER BY id DESC');
}

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} else {
    http_response_code(404);
    echo json_encode(['codigo' => '-1', 'mensaje' => 'No records found']);
}
