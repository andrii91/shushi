<?php
// ЗМІНІТЬ ЦЕЙ ПАРОЛЬ перед завантаженням на сервер!
define('ADMIN_PASSWORD', 'demo1234');

// Шлях до файлу меню: admin/ → одним рівнем вище → data/menu.json
define('MENU_JSON_PATH', __DIR__ . '/../data/menu.json');

// Шлях до файлу налаштувань сайту (назва, телефон, адреса, соцмережі тощо)
define('SETTINGS_JSON_PATH', __DIR__ . '/../data/settings.json');

// Папки для завантаження картинок за призначенням (target → [dir, url])
define('UPLOAD_TARGETS', [
    'menu' => [__DIR__ . '/../images/menu/', '/images/menu/'],
    'site' => [__DIR__ . '/../images/site/', '/images/site/'],
]);

// Папка для завантаження картинок (за замовчуванням — меню)
define('UPLOAD_DIR', __DIR__ . '/../images/menu/');
define('UPLOAD_URL', '/images/menu/');

// Дозволені типи файлів для картинок
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 MB

/**
 * Прибирає з теки $dir зображення, на які немає посилань.
 * $keepUrls — масив URL/шляхів, що використовуються (наприклад "/images/menu/1.webp").
 * Лишає .svg (плейсхолдери). Видаляє лише звичайні файли в межах $dir.
 * Повертає кількість видалених файлів. Помилки видалення ігноруються (не ламають збереження).
 */
function prune_unused_images(string $dir, array $keepUrls): int {
    if (!is_dir($dir)) {
        return 0;
    }
    // Дозволені до збереження — за базовим іменем файлу
    $keep = [];
    foreach ($keepUrls as $u) {
        if (is_string($u) && $u !== '') {
            $keep[basename($u)] = true;
        }
    }
    $removed = 0;
    foreach (scandir($dir) ?: [] as $name) {
        if ($name === '.' || $name === '..') {
            continue;
        }
        $full = $dir . $name;
        if (!is_file($full)) {
            continue;
        }
        if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'svg') {
            continue; // плейсхолдери лишаємо
        }
        if (isset($keep[$name])) {
            continue; // використовується
        }
        if (@unlink($full)) {
            $removed++;
        }
    }
    return $removed;
}
