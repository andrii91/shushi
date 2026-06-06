<?php
require_once 'config.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// CSRF через POST поле
if (empty($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['image'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['image'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Upload error: ' . $file['error']]);
    exit;
}

if ($file['size'] > MAX_FILE_SIZE) {
    http_response_code(400);
    echo json_encode(['error' => 'File too large (max 10MB)']);
    exit;
}

// Перевірка розширення
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, ALLOWED_EXTENSIONS, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid file type. Allowed: jpg, jpeg, png, webp, gif']);
    exit;
}

// Перевірка реального типу файлу через finfo
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file['tmp_name']);
$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($mimeType, $allowedMimes, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid file content']);
    exit;
}

// Куди зберігати: 'menu' (за замовчуванням) або 'site' (лого / фон шапки)
$target = $_POST['target'] ?? 'menu';
$targets = UPLOAD_TARGETS;
if (!isset($targets[$target])) {
    $target = 'menu';
}
[$uploadDir, $uploadUrl] = $targets[$target];

// Унікальне ім'я файлу
$newName = uniqid('img_', true) . '.' . $ext;
$destination = $uploadDir . $newName;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save file']);
    exit;
}

echo json_encode([
    'success' => true,
    'url' => $uploadUrl . $newName,
    'filename' => $newName,
]);
