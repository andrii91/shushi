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

$input = json_decode(file_get_contents('php://input'), true);

// Перевірка CSRF токену
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

$settings = $input['settings'] ?? null;
if (!is_array($settings)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

// Допоміжна: переклад {pl,en,ua} → нормалізований об'єкт рядків
function tr($v): array {
    return [
        'pl' => is_string($v['pl'] ?? null) ? $v['pl'] : '',
        'en' => is_string($v['en'] ?? null) ? $v['en'] : '',
        'ua' => is_string($v['ua'] ?? null) ? $v['ua'] : '',
    ];
}

$allowedSocials = ['instagram', 'facebook', 'tiktok', 'youtube', 'telegram', 'whatsapp', 'viber', 'x'];

// Нормалізація / валідація структури — приймаємо лише відомі поля
$socials = [];
foreach (($settings['socials'] ?? []) as $s) {
    $type = $s['type'] ?? '';
    $url = trim((string)($s['url'] ?? ''));
    if (in_array($type, $allowedSocials, true) && $url !== '') {
        $socials[] = ['type' => $type, 'url' => $url];
    }
}

$lines = [];
foreach (($settings['hours']['lines'] ?? []) as $line) {
    $lines[] = tr($line);
}

$clean = [
    'name' => (string)($settings['name'] ?? ''),
    'phone' => (string)($settings['phone'] ?? ''),
    'currency' => (string)($settings['currency'] ?? 'zł'),
    'logo' => (string)($settings['logo'] ?? ''),
    'headerImage' => (string)($settings['headerImage'] ?? ''),
    'mapUrl' => (string)($settings['mapUrl'] ?? ''),
    'address' => tr($settings['address'] ?? []),
    'hours' => [
        'title' => tr($settings['hours']['title'] ?? []),
        'lines' => $lines,
    ],
    'socials' => $socials,
];

$json = json_encode($clean, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
if ($json === false) {
    http_response_code(500);
    echo json_encode(['error' => 'JSON encoding failed']);
    exit;
}

// Атомарний запис через тимчасовий файл
$tmpFile = SETTINGS_JSON_PATH . '.tmp';
if (file_put_contents($tmpFile, $json) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Cannot write file. Check permissions.']);
    exit;
}

rename($tmpFile, SETTINGS_JSON_PATH);

// Прибираємо старі лого/фон, які більше не використовуються
[$siteDir] = UPLOAD_TARGETS['site'];
$pruned = prune_unused_images($siteDir, [$clean['logo'], $clean['headerImage']]);

echo json_encode(['success' => true, 'pruned' => $pruned]);
