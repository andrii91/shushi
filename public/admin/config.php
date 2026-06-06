<?php
// ЗМІНІТЬ ЦЕЙ ПАРОЛЬ перед завантаженням на сервер!
define('ADMIN_PASSWORD', 'Charger_91');

// Шлях до файлу меню: admin/ → одним рівнем вище → data/menu.json
define('MENU_JSON_PATH', __DIR__ . '/../data/menu.json');

// Папка для завантаження картинок
define('UPLOAD_DIR', __DIR__ . '/../images/menu/');
define('UPLOAD_URL', '/images/menu/');

// Дозволені типи файлів для картинок
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 MB
