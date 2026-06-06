<?php
require_once 'config.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

// Перевірка авторизації
if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Перевірка CSRF токену
$input = json_decode(file_get_contents('php://input'), true);
if (empty($input['csrf']) || $input['csrf'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$categories = $input['categories'] ?? null;
if (!is_array($categories)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

// Валідація структури
foreach ($categories as $cat) {
    if (!isset($cat['id'], $cat['title'], $cat['items'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid category structure']);
        exit;
    }
    foreach ($cat['items'] as $item) {
        if (!isset($item['id'], $item['price'], $item['name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid item structure']);
            exit;
        }
        // Ціна повинна бути числом
        if (!is_numeric($item['price'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Price must be a number']);
            exit;
        }
    }
}

$data = ['categories' => $categories];
$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

if ($json === false) {
    http_response_code(500);
    echo json_encode(['error' => 'JSON encoding failed']);
    exit;
}

// Атомарний запис через тимчасовий файл
$tmpFile = MENU_JSON_PATH . '.tmp';
if (file_put_contents($tmpFile, $json) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Cannot write file. Check permissions.']);
    exit;
}

rename($tmpFile, MENU_JSON_PATH);

echo json_encode(['success' => true]);
