<?php
require_once 'config.php';
session_start();

$error = '';
$success = '';

// Логін / логаут
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'login') {
        if ($_POST['password'] === ADMIN_PASSWORD) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } else {
            $error = 'Невірний пароль';
        }
    } elseif ($_POST['action'] === 'logout') {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

$isLogged = !empty($_SESSION['admin_logged_in']);
$csrfToken = $_SESSION['csrf_token'] ?? '';

// Читання поточного меню
$menuData = ['categories' => []];
if ($isLogged && file_exists(MENU_JSON_PATH)) {
    $raw = file_get_contents(MENU_JSON_PATH);
    $decoded = json_decode($raw, true);
    if ($decoded) $menuData = $decoded;
}

// Читання поточних налаштувань сайту
$settings = [
    'name' => '', 'phone' => '', 'currency' => 'грн', 'logo' => '', 'headerImage' => '', 'mapUrl' => '',
    'address' => ['pl' => '', 'en' => '', 'ua' => ''],
    'hours' => ['title' => ['pl' => '', 'en' => '', 'ua' => ''], 'lines' => []],
    'socials' => [],
];
if (file_exists(SETTINGS_JSON_PATH)) {
    $raw = file_get_contents(SETTINGS_JSON_PATH);
    $decoded = json_decode($raw, true);
    if ($decoded) $settings = array_merge($settings, $decoded);
}

// Назва закладу для заголовків адмінки (фолбек, якщо ще не задано)
$siteName = $settings['name'] !== '' ? $settings['name'] : 'Адмінка';

// Доступні соцмережі: значення → підпис
$SOCIAL_TYPES = [
    'instagram' => 'Instagram', 'facebook' => 'Facebook', 'tiktok' => 'TikTok',
    'youtube' => 'YouTube', 'telegram' => 'Telegram', 'whatsapp' => 'WhatsApp',
    'viber' => 'Viber', 'x' => 'X (Twitter)',
];

// Available currency symbols
$CURRENCIES = ['zł', '€', '$', '₴', 'грн', '£', 'Kč'];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($siteName) ?> — Адмінка</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: system-ui, sans-serif; background: #111; color: #eee; min-height: 100vh; }
a { color: #d1be8f; }

/* Login */
.login-wrap { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
.login-box { background: #1e1e1e; border-radius: 16px; padding: 40px; width: 100%; max-width: 360px; }
.login-box h1 { color: #d1be8f; margin-bottom: 24px; font-size: 22px; text-align: center; }
.error { background: #5c1a1a; color: #ff9a9a; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
.success-msg { background: #1a4a2a; color: #7dff9a; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }

/* Form controls */
label { display: block; font-size: 13px; color: #999; margin-bottom: 4px; margin-top: 12px; }
input[type=text], input[type=password], input[type=number], textarea, select {
  width: 100%; padding: 9px 12px; background: #2a2a2a; border: 1px solid #3a3a3a;
  border-radius: 8px; color: #eee; font-size: 14px; font-family: inherit;
}
input:focus, textarea:focus, select:focus { outline: none; border-color: #d1be8f; }
textarea { resize: vertical; min-height: 72px; }

/* Buttons */
.btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border: none;
  border-radius: 8px; font-size: 14px; cursor: pointer; font-family: inherit; transition: .2s; }
.btn-gold { background: #d1be8f; color: #111; font-weight: 600; }
.btn-gold:hover { background: #e8d4a5; }
.btn-danger { background: #5c1a1a; color: #ff9a9a; }
.btn-danger:hover { background: #7a2020; }
.btn-ghost { background: #2a2a2a; color: #aaa; border: 1px solid #3a3a3a; }
.btn-ghost:hover { background: #333; color: #eee; }
.btn-sm { padding: 5px 12px; font-size: 12px; }
.btn-save-all { width: 100%; padding: 14px; font-size: 16px; margin-top: 24px; }

/* Layout */
.topbar { background: #1a1a1a; border-bottom: 1px solid #2a2a2a; padding: 12px 24px;
  display: flex; align-items: center; justify-content: space-between; }
.topbar-title { color: #d1be8f; font-weight: bold; font-size: 18px; }
.container { max-width: 900px; margin: 0 auto; padding: 24px 16px 80px; }

/* Categories */
.cat-block { background: #1e1e1e; border-radius: 12px; margin-bottom: 16px; border: 1px solid #2a2a2a; }
.cat-header { display: flex; align-items: center; gap: 10px; padding: 14px 16px;
  cursor: pointer; user-select: none; border-radius: 12px; transition: .2s; }
.cat-header:hover { background: #252525; }
.cat-header-title { flex: 1; font-weight: 600; color: #d1be8f; font-size: 16px; }
.cat-header-count { font-size: 12px; color: #666; }
.cat-body { padding: 0 16px 16px; display: none; }
.cat-body.open { display: block; }

/* Category title fields */
.lang-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 12px; }
.lang-label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 3px; }

/* Items */
.item-block { background: #252525; border-radius: 10px; padding: 14px; margin-bottom: 10px; border: 1px solid #303030; }
.item-header { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
.item-img-preview { width: 56px; height: 56px; border-radius: 8px; object-fit: cover; background: #333; flex-shrink: 0; }
.item-name-preview { font-weight: 600; font-size: 15px; flex: 1; }
.item-price-badge { background: #d1be8f22; color: #d1be8f; padding: 3px 10px; border-radius: 100px; font-size: 13px; font-weight: 600; }

.fields-grid { display: grid; gap: 8px; }
.fields-section { margin-top: 10px; }
.fields-section-title { font-size: 11px; color: #777; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; border-top: 1px solid #333; padding-top: 8px; }

/* Image upload */
.img-upload-row { display: flex; align-items: center; gap: 10px; margin-top: 8px; }
.img-upload-row input[type=file] { flex: 1; background: none; border: 1px dashed #444; padding: 6px; border-radius: 8px; color: #aaa; font-size: 13px; }
.img-uploading { font-size: 12px; color: #d1be8f; }

/* Add buttons */
.add-item-btn { width: 100%; margin-top: 8px; border: 1px dashed #444; color: #888; background: transparent; }
.add-item-btn:hover { border-color: #d1be8f; color: #d1be8f; }
.add-cat-btn { margin-bottom: 16px; }

/* Sticky save */
.save-bar { position: fixed; bottom: 0; left: 0; right: 0; background: #111; border-top: 1px solid #2a2a2a;
  padding: 12px 16px; display: flex; gap: 12px; justify-content: center; z-index: 100; }
.save-status { font-size: 13px; color: #888; align-self: center; }
.save-status.ok { color: #7dff9a; }
.save-status.err { color: #ff9a9a; }

.chevron { transition: transform .2s; display: inline-block; }
.chevron.open { transform: rotate(90deg); }

/* Drag & Drop */
.drag-handle {
  cursor: grab; color: #555; font-size: 18px; line-height: 1;
  padding: 4px 6px; border-radius: 6px; flex-shrink: 0; transition: color .15s;
  user-select: none; touch-action: none;
}
.drag-handle:hover { color: #d1be8f; background: #2a2a2a; }
.drag-handle:active { cursor: grabbing; }
.sortable-ghost { opacity: 0.35; background: #d1be8f18 !important; border: 1px dashed #d1be8f !important; }
.sortable-chosen { box-shadow: 0 4px 20px #0008; }
.sortable-drag { opacity: 1 !important; }
</style>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
</head>
<body>

<?php if (!$isLogged): ?>
<div class="login-wrap">
  <div class="login-box">
    <h1><?= htmlspecialchars($siteName) ?> — Адмінка</h1>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="action" value="login">
      <label>Пароль</label>
      <input type="password" name="password" autofocus autocomplete="current-password">
      <br><br>
      <button type="submit" class="btn btn-gold" style="width:100%">Увійти</button>
    </form>
  </div>
</div>

<?php else: ?>

<div class="topbar">
  <span class="topbar-title"><?= htmlspecialchars($siteName) ?> — Адмінка</span>
  <div style="display:flex;gap:10px;align-items:center">
    <a href="/" target="_blank" class="btn btn-ghost btn-sm">← Сайт</a>
    <form method="post" style="margin:0">
      <input type="hidden" name="action" value="logout">
      <button class="btn btn-ghost btn-sm">Вийти</button>
    </form>
  </div>
</div>

<div class="container">

<!-- ───────────── Налаштування сайту ───────────── -->
<div class="cat-block" id="settings-block">
  <div class="cat-header" onclick="toggleCat(this)">
    <span class="chevron">▶</span>
    <span class="cat-header-title">⚙️ Налаштування сайту</span>
  </div>
  <div class="cat-body">

    <div class="fields-section">
      <div class="fields-section-title">Назва закладу</div>
      <input type="text" id="set-name" value="<?= htmlspecialchars($settings['name'] ?? '') ?>">
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Телефон</div>
      <input type="text" id="set-phone" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>" placeholder="+48 100 200 300">
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Валюта</div>
      <select id="set-currency" style="max-width:160px" onchange="refreshCurrencyLabels()">
        <?php
          $curr = $settings['currency'] ?? 'грн';
          $currOpts = $CURRENCIES;
          if ($curr !== '' && !in_array($curr, $currOpts, true)) array_unshift($currOpts, $curr);
          foreach ($currOpts as $c): ?>
        <option value="<?= htmlspecialchars($c) ?>" <?= $curr === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Логотип</div>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
        <img class="set-logo-preview" src="<?= htmlspecialchars($settings['logo'] ?: '/images/site/logo.webp') ?>" style="width:48px;height:48px;border-radius:8px;object-fit:cover;background:#333" onerror="this.style.opacity=.3">
        <input type="text" id="set-logo" value="<?= htmlspecialchars($settings['logo'] ?? '') ?>" placeholder="/images/site/logo.webp" style="flex:1" oninput="document.querySelector('.set-logo-preview').src=this.value">
      </div>
      <div class="img-upload-row">
        <input type="file" accept="image/*" onchange="uploadSiteImage(this,'set-logo','.set-logo-preview')">
        <span class="img-uploading" style="display:none">Завантаження...</span>
      </div>
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Фонова картинка шапки</div>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
        <img class="set-header-preview" src="<?= htmlspecialchars($settings['headerImage'] ?: '/images/site/header.webp') ?>" style="width:96px;height:48px;border-radius:8px;object-fit:cover;background:#333" onerror="this.style.opacity=.3">
        <input type="text" id="set-header" value="<?= htmlspecialchars($settings['headerImage'] ?? '') ?>" placeholder="/images/site/header.webp" style="flex:1" oninput="document.querySelector('.set-header-preview').src=this.value">
      </div>
      <div class="img-upload-row">
        <input type="file" accept="image/*" onchange="uploadSiteImage(this,'set-header','.set-header-preview')">
        <span class="img-uploading" style="display:none">Завантаження...</span>
      </div>
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Адреса</div>
      <div class="lang-row">
        <div><div class="lang-label">🇵🇱 PL</div><input type="text" id="set-address-pl" value="<?= htmlspecialchars($settings['address']['pl'] ?? '') ?>"></div>
        <div><div class="lang-label">🇬🇧 EN</div><input type="text" id="set-address-en" value="<?= htmlspecialchars($settings['address']['en'] ?? '') ?>"></div>
        <div><div class="lang-label">🇺🇦 UA</div><input type="text" id="set-address-ua" value="<?= htmlspecialchars($settings['address']['ua'] ?? '') ?>"></div>
      </div>
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Посилання на карту (Google Maps)</div>
      <input type="text" id="set-mapurl" value="<?= htmlspecialchars($settings['mapUrl'] ?? '') ?>" placeholder="https://maps.google.com/?q=...">
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Робочі години — заголовок</div>
      <div class="lang-row">
        <div><div class="lang-label">🇵🇱 PL</div><input type="text" id="set-hours-title-pl" value="<?= htmlspecialchars($settings['hours']['title']['pl'] ?? '') ?>"></div>
        <div><div class="lang-label">🇬🇧 EN</div><input type="text" id="set-hours-title-en" value="<?= htmlspecialchars($settings['hours']['title']['en'] ?? '') ?>"></div>
        <div><div class="lang-label">🇺🇦 UA</div><input type="text" id="set-hours-title-ua" value="<?= htmlspecialchars($settings['hours']['title']['ua'] ?? '') ?>"></div>
      </div>
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Робочі години — рядки</div>
      <div id="hours-lines">
        <?php foreach (($settings['hours']['lines'] ?? []) as $line): ?>
        <div class="hours-line" style="margin-bottom:10px">
          <div style="display:flex;gap:8px;align-items:flex-end">
            <div class="lang-row" style="flex:1;margin-bottom:0">
              <div><div class="lang-label">🇵🇱 PL</div><input type="text" class="hl-pl" value="<?= htmlspecialchars($line['pl'] ?? '') ?>"></div>
              <div><div class="lang-label">🇬🇧 EN</div><input type="text" class="hl-en" value="<?= htmlspecialchars($line['en'] ?? '') ?>"></div>
              <div><div class="lang-label">🇺🇦 UA</div><input type="text" class="hl-ua" value="<?= htmlspecialchars($line['ua'] ?? '') ?>"></div>
            </div>
            <button class="btn btn-danger btn-sm" onclick="this.closest('.hours-line').remove()">✕</button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <button class="btn btn-ghost btn-sm add-item-btn" onclick="addHoursLine()">+ Додати рядок</button>
    </div>

    <div class="fields-section">
      <div class="fields-section-title">Соцмережі</div>
      <div id="socials-list">
        <?php foreach (($settings['socials'] ?? []) as $s): ?>
        <div class="social-row" style="display:flex;gap:8px;margin-bottom:8px;align-items:center">
          <select class="social-type" style="max-width:160px">
            <?php foreach ($SOCIAL_TYPES as $val => $label): ?>
            <option value="<?= $val ?>" <?= ($s['type'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
          </select>
          <input type="text" class="social-url" value="<?= htmlspecialchars($s['url'] ?? '') ?>" placeholder="https://..." style="flex:1">
          <button class="btn btn-danger btn-sm" onclick="this.closest('.social-row').remove()">✕</button>
        </div>
        <?php endforeach; ?>
      </div>
      <button class="btn btn-ghost btn-sm add-item-btn" onclick="addSocial()">+ Додати соцмережу</button>
    </div>

    <div style="display:flex;align-items:center;gap:12px;margin-top:20px">
      <button class="btn btn-gold" onclick="saveSettings()">💾 Зберегти налаштування</button>
      <span class="save-status" id="settings-status"></span>
    </div>

  </div>
</div>

<button class="btn btn-gold add-cat-btn" onclick="addCategory()">+ Додати категорію</button>

<div id="categories-wrap">
<?php foreach ($menuData['categories'] as $catIdx => $cat): ?>
<div class="cat-block" data-cat-idx="<?= $catIdx ?>">
  <div class="cat-header" onclick="toggleCat(this)">
    <span class="drag-handle cat-drag-handle" onclick="event.stopPropagation()" title="Перетягнути категорію">⠿</span>
    <span class="chevron">▶</span>
    <span class="cat-header-title"><?= htmlspecialchars($cat['title']['ua'] ?? '') ?></span>
    <span class="cat-header-count"><?= count($cat['items']) ?> позицій</span>
    <button class="btn btn-danger btn-sm" onclick="event.stopPropagation();removeCat(this)">✕</button>
  </div>
  <div class="cat-body">
    <div class="fields-section">
      <div class="fields-section-title">Назва категорії</div>
      <div class="lang-row">
        <div><div class="lang-label">🇵🇱 Polish</div><input type="text" class="cat-title-pl" value="<?= htmlspecialchars($cat['title']['pl'] ?? '') ?>" oninput="updateCatTitle(this,'pl')"></div>
        <div><div class="lang-label">🇬🇧 English</div><input type="text" class="cat-title-en" value="<?= htmlspecialchars($cat['title']['en'] ?? '') ?>" oninput="updateCatTitle(this,'en')"></div>
        <div><div class="lang-label">🇺🇦 Українська</div><input type="text" class="cat-title-ua" value="<?= htmlspecialchars($cat['title']['ua'] ?? '') ?>" oninput="updateCatTitle(this,'ua')"></div>
      </div>
    </div>

    <div class="items-wrap">
    <?php foreach ($cat['items'] as $itemIdx => $item): ?>
    <div class="item-block" data-item-idx="<?= $itemIdx ?>">
      <div class="item-header">
        <span class="drag-handle item-drag-handle" title="Перетягнути позицію">⠿</span>
        <img class="item-img-preview" src="<?= htmlspecialchars($item['image'] ?? '/images/menu/empty.svg') ?>" alt="" onerror="this.src='/images/menu/empty.svg'">
        <span class="item-name-preview"><?= htmlspecialchars($item['name']['ua'] ?? '') ?></span>
        <span class="item-price-badge"><?= (int)($item['price'] ?? 0) ?> <?= htmlspecialchars($curr) ?></span>
        <button class="btn btn-danger btn-sm" onclick="removeItem(this)">✕</button>
      </div>

      <div class="fields-grid">
        <div>
          <label>Ціна (<?= htmlspecialchars($curr) ?>)</label>
          <input type="number" class="item-price" value="<?= (int)($item['price'] ?? 0) ?>" min="0" step="1" oninput="updatePriceBadge(this)">
        </div>

        <div class="fields-section">
          <div class="fields-section-title">Назва позиції</div>
          <div class="lang-row">
            <div><div class="lang-label">🇵🇱 PL</div><input type="text" class="item-name-pl" value="<?= htmlspecialchars($item['name']['pl'] ?? '') ?>" oninput="updateNamePreview(this)"></div>
            <div><div class="lang-label">🇬🇧 EN</div><input type="text" class="item-name-en" value="<?= htmlspecialchars($item['name']['en'] ?? '') ?>"></div>
            <div><div class="lang-label">🇺🇦 UA</div><input type="text" class="item-name-ua" value="<?= htmlspecialchars($item['name']['ua'] ?? '') ?>"></div>
          </div>
        </div>

        <div class="fields-section">
          <div class="fields-section-title">Опис</div>
          <div class="lang-row">
            <div><div class="lang-label">🇵🇱 PL</div><textarea class="item-desc-pl"><?= htmlspecialchars($item['description']['pl'] ?? '') ?></textarea></div>
            <div><div class="lang-label">🇬🇧 EN</div><textarea class="item-desc-en"><?= htmlspecialchars($item['description']['en'] ?? '') ?></textarea></div>
            <div><div class="lang-label">🇺🇦 UA</div><textarea class="item-desc-ua"><?= htmlspecialchars($item['description']['ua'] ?? '') ?></textarea></div>
          </div>
        </div>

        <div class="fields-section">
          <div class="fields-section-title">Кількість / склад (необов'язково)</div>
          <div class="lang-row">
            <div><div class="lang-label">🇵🇱 PL</div><input type="text" class="item-count-pl" value="<?= htmlspecialchars($item['count']['pl'] ?? '') ?>"></div>
            <div><div class="lang-label">🇬🇧 EN</div><input type="text" class="item-count-en" value="<?= htmlspecialchars($item['count']['en'] ?? '') ?>"></div>
            <div><div class="lang-label">🇺🇦 UA</div><input type="text" class="item-count-ua" value="<?= htmlspecialchars($item['count']['ua'] ?? '') ?>"></div>
          </div>
        </div>

        <?php if (!empty($item['rollsDescription'])): ?>
        <div class="fields-section">
          <div class="fields-section-title">Опис роллів (для наборів)</div>
          <div class="lang-row">
            <div><div class="lang-label">🇵🇱 PL</div><textarea class="item-rolls-pl"><?= htmlspecialchars($item['rollsDescription']['pl'] ?? '') ?></textarea></div>
            <div><div class="lang-label">🇬🇧 EN</div><textarea class="item-rolls-en"><?= htmlspecialchars($item['rollsDescription']['en'] ?? '') ?></textarea></div>
            <div><div class="lang-label">🇺🇦 UA</div><textarea class="item-rolls-ua"><?= htmlspecialchars($item['rollsDescription']['ua'] ?? '') ?></textarea></div>
          </div>
        </div>
        <?php else: ?>
        <div class="fields-section rolls-section" style="display:none">
          <div class="fields-section-title">Опис роллів (для наборів)</div>
          <div class="lang-row">
            <div><div class="lang-label">🇵🇱 PL</div><textarea class="item-rolls-pl"></textarea></div>
            <div><div class="lang-label">🇬🇧 EN</div><textarea class="item-rolls-en"></textarea></div>
            <div><div class="lang-label">🇺🇦 UA</div><textarea class="item-rolls-ua"></textarea></div>
          </div>
        </div>
        <button class="btn btn-ghost btn-sm" style="margin-top:6px" onclick="toggleRolls(this)">+ Додати опис роллів</button>
        <?php endif; ?>

        <div class="fields-section">
          <div class="fields-section-title">Картинка</div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
            <img class="item-img-preview" src="<?= htmlspecialchars($item['image'] ?? '/images/menu/empty.svg') ?>" alt="" style="width:48px;height:48px" onerror="this.src='/images/menu/empty.svg'">
            <input type="text" class="item-image-url" value="<?= htmlspecialchars($item['image'] ?? '/images/menu/empty.svg') ?>" placeholder="/images/menu/..." style="flex:1" oninput="updateImgPreview(this)">
          </div>
          <div class="img-upload-row">
            <input type="file" class="item-image-file" accept="image/*" onchange="uploadImage(this)">
            <span class="img-uploading" style="display:none">Завантаження...</span>
          </div>
        </div>

        <input type="hidden" class="item-id" value="<?= (int)($item['id'] ?? 0) ?>">
      </div>
    </div>
    <?php endforeach; ?>
    </div>

    <button class="btn btn-ghost add-item-btn" onclick="addItem(this)">+ Додати позицію</button>
  </div>
</div>
<?php endforeach; ?>
</div>

</div><!-- /container -->

<div class="save-bar">
  <button class="btn btn-gold" style="padding:10px 32px;font-size:15px" onclick="saveAll()">💾 Зберегти меню</button>
  <span class="save-status" id="save-status"></span>
</div>

<script>
const CSRF = <?= json_encode($csrfToken) ?>;
const SOCIAL_TYPES = <?= json_encode($SOCIAL_TYPES) ?>;

// ───────────── Налаштування сайту ─────────────

function val(id) { return document.getElementById(id)?.value || ''; }

function escapeHtml(s) {
  return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;')
    .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function socialOptions(selected) {
  return Object.entries(SOCIAL_TYPES)
    .map(([v, l]) => `<option value="${v}" ${v === selected ? 'selected' : ''}>${l}</option>`)
    .join('');
}

function addSocial(type = 'instagram', url = '') {
  const div = document.createElement('div');
  div.className = 'social-row';
  div.style.cssText = 'display:flex;gap:8px;margin-bottom:8px;align-items:center';
  div.innerHTML = `
    <select class="social-type" style="max-width:160px">${socialOptions(type)}</select>
    <input type="text" class="social-url" value="${escapeHtml(url)}" placeholder="https://..." style="flex:1">
    <button class="btn btn-danger btn-sm" onclick="this.closest('.social-row').remove()">✕</button>`;
  document.getElementById('socials-list').appendChild(div);
}

function addHoursLine() {
  const div = document.createElement('div');
  div.className = 'hours-line';
  div.style.marginBottom = '10px';
  div.innerHTML = `
    <div style="display:flex;gap:8px;align-items:flex-end">
      <div class="lang-row" style="flex:1;margin-bottom:0">
        <div><div class="lang-label">🇵🇱 PL</div><input type="text" class="hl-pl"></div>
        <div><div class="lang-label">🇬🇧 EN</div><input type="text" class="hl-en"></div>
        <div><div class="lang-label">🇺🇦 UA</div><input type="text" class="hl-ua"></div>
      </div>
      <button class="btn btn-danger btn-sm" onclick="this.closest('.hours-line').remove()">✕</button>
    </div>`;
  document.getElementById('hours-lines').appendChild(div);
}

async function uploadSiteImage(input, fieldId, previewSel) {
  const statusEl = input.nextElementSibling;
  statusEl.style.display = 'inline';
  input.disabled = true;
  const fd = new FormData();
  fd.append('image', input.files[0]);
  fd.append('csrf', CSRF);
  fd.append('target', 'site');
  try {
    const res = await fetch('/admin/upload.php', { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) {
      document.getElementById(fieldId).value = data.url;
      const p = document.querySelector(previewSel);
      if (p) { p.src = data.url; p.style.opacity = 1; }
    } else {
      alert('Помилка завантаження: ' + (data.error || 'невідома'));
    }
  } catch {
    alert('Помилка мережі при завантаженні');
  }
  statusEl.style.display = 'none';
  input.disabled = false;
  input.value = '';
}

async function saveSettings() {
  const statusEl = document.getElementById('settings-status');
  statusEl.textContent = 'Збереження...';
  statusEl.className = 'save-status';

  const lines = [...document.querySelectorAll('#hours-lines .hours-line')].map(el => ({
    pl: el.querySelector('.hl-pl')?.value || '',
    en: el.querySelector('.hl-en')?.value || '',
    ua: el.querySelector('.hl-ua')?.value || '',
  }));

  const socials = [...document.querySelectorAll('#socials-list .social-row')].map(el => ({
    type: el.querySelector('.social-type')?.value || '',
    url: (el.querySelector('.social-url')?.value || '').trim(),
  })).filter(s => s.url);

  const settings = {
    name: val('set-name'),
    phone: val('set-phone'),
    currency: val('set-currency'),
    logo: val('set-logo'),
    headerImage: val('set-header'),
    mapUrl: val('set-mapurl'),
    address: { pl: val('set-address-pl'), en: val('set-address-en'), ua: val('set-address-ua') },
    hours: {
      title: { pl: val('set-hours-title-pl'), en: val('set-hours-title-en'), ua: val('set-hours-title-ua') },
      lines,
    },
    socials,
  };

  try {
    const res = await fetch('/admin/settings.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ settings, csrf: CSRF }),
    });
    const data = await res.json();
    if (data.success) {
      statusEl.textContent = '✓ Збережено!';
      statusEl.className = 'save-status ok';
    } else {
      statusEl.textContent = '✗ Помилка: ' + (data.error || 'невідома');
      statusEl.className = 'save-status err';
    }
  } catch {
    statusEl.textContent = '✗ Помилка мережі';
    statusEl.className = 'save-status err';
  }
  setTimeout(() => { statusEl.textContent = ''; statusEl.className = 'save-status'; }, 4000);
}

// ──────────────────────────────────────────────

let nextId = <?php
  $allItems = [];
  foreach ($menuData['categories'] as $c) {
    foreach ($c['items'] as $it) $allItems[] = $it['id'] ?? 0;
  }
  echo (empty($allItems) ? 100 : max($allItems)) + 1;
?>;

// Collapse/expand
function toggleCat(header) {
  const body = header.nextElementSibling;
  const chev = header.querySelector('.chevron');
  const isOpen = body.classList.toggle('open');
  chev.classList.toggle('open', isOpen);
  const titleEl = header.querySelector('.cat-header-title');
  const ua = header.closest('.cat-block').querySelector('.cat-title-ua');
  if (ua) titleEl.textContent = ua.value || '(без назви)';
}

function updateCatTitle(input, lang) {
  const block = input.closest('.cat-block');
  if (lang === 'ua') {
    block.querySelector('.cat-header-title').textContent = input.value || '(без назви)';
  }
}

function currentCurrency() {
  return document.getElementById('set-currency')?.value || 'грн';
}

function updatePriceBadge(input) {
  const badge = input.closest('.item-block').querySelector('.item-price-badge');
  badge.textContent = (parseInt(input.value) || 0) + ' ' + currentCurrency();
}

function refreshCurrencyLabels() {
  const curr = currentCurrency();
  document.querySelectorAll('.item-price-badge').forEach(b => {
    b.textContent = (parseInt(b.textContent) || 0) + ' ' + curr;
  });
  document.querySelectorAll('.item-price').forEach(inp => {
    const label = inp.closest('div')?.querySelector('label');
    if (label) label.textContent = 'Ціна (' + curr + ')';
  });
}

function updateNamePreview(input) {
  const block = input.closest('.item-block');
  block.querySelector('.item-name-preview').textContent = input.value || '(без назви)';
}

function updateImgPreview(input) {
  const block = input.closest('.item-block');
  const imgs = block.querySelectorAll('.item-img-preview');
  imgs.forEach(img => img.src = input.value || '/images/menu/empty.svg');
}

function toggleRolls(btn) {
  const section = btn.previousElementSibling;
  section.style.display = 'block';
  btn.remove();
}

// Remove category
function removeCat(btn) {
  if (!confirm('Видалити категорію?')) return;
  btn.closest('.cat-block').remove();
}

// Remove item
function removeItem(btn) {
  if (!confirm('Видалити позицію?')) return;
  btn.closest('.item-block').remove();
  // update count
  const catBlock = btn.closest('.cat-block');
  catBlock.querySelector('.cat-header-count').textContent =
    catBlock.querySelectorAll('.item-block').length + ' позицій';
}

// Add category
function addCategory() {
  const wrap = document.getElementById('categories-wrap');
  const div = document.createElement('div');
  div.className = 'cat-block';
  div.innerHTML = `
    <div class="cat-header" onclick="toggleCat(this)">
      <span class="drag-handle cat-drag-handle" onclick="event.stopPropagation()" title="Перетягнути категорію">⠿</span>
      <span class="chevron open">▶</span>
      <span class="cat-header-title">(нова категорія)</span>
      <span class="cat-header-count">0 позицій</span>
      <button class="btn btn-danger btn-sm" onclick="event.stopPropagation();removeCat(this)">✕</button>
    </div>
    <div class="cat-body open">
      <div class="fields-section">
        <div class="fields-section-title">Назва категорії</div>
        <div class="lang-row">
          <div><div class="lang-label">🇵🇱 Polish</div><input type="text" class="cat-title-pl" placeholder="Назва PL" oninput="updateCatTitle(this,'pl')"></div>
          <div><div class="lang-label">🇬🇧 English</div><input type="text" class="cat-title-en" placeholder="Name EN"></div>
          <div><div class="lang-label">🇺🇦 Українська</div><input type="text" class="cat-title-ua" placeholder="Назва UA"></div>
        </div>
      </div>
      <div class="items-wrap"></div>
      <button class="btn btn-ghost add-item-btn" onclick="addItem(this)">+ Додати позицію</button>
    </div>`;
  wrap.appendChild(div);
  initItemsSortable(div.querySelector('.items-wrap'));
  div.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Add item
function addItem(btn) {
  const itemsWrap = btn.previousElementSibling;
  const id = nextId++;
  const div = document.createElement('div');
  div.className = 'item-block';
  div.innerHTML = `
    <div class="item-header">
      <span class="drag-handle item-drag-handle" title="Перетягнути позицію">⠿</span>
      <img class="item-img-preview" src="/images/menu/empty.svg" style="width:56px;height:56px;border-radius:8px;object-fit:cover">
      <span class="item-name-preview">(нова позиція)</span>
      <span class="item-price-badge">0 ${currentCurrency()}</span>
      <button class="btn btn-danger btn-sm" onclick="removeItem(this)">✕</button>
    </div>
    <div class="fields-grid">
      <div>
        <label>Ціна (${currentCurrency()})</label>
        <input type="number" class="item-price" value="0" min="0" step="1" oninput="updatePriceBadge(this)">
      </div>
      <div class="fields-section">
        <div class="fields-section-title">Назва позиції</div>
        <div class="lang-row">
          <div><div class="lang-label">🇵🇱 PL</div><input type="text" class="item-name-pl" placeholder="Назва PL" oninput="updateNamePreview(this)"></div>
          <div><div class="lang-label">🇬🇧 EN</div><input type="text" class="item-name-en" placeholder="Name EN"></div>
          <div><div class="lang-label">🇺🇦 UA</div><input type="text" class="item-name-ua" placeholder="Назва UA"></div>
        </div>
      </div>
      <div class="fields-section">
        <div class="fields-section-title">Опис</div>
        <div class="lang-row">
          <div><div class="lang-label">🇵🇱 PL</div><textarea class="item-desc-pl" placeholder="Опис PL"></textarea></div>
          <div><div class="lang-label">🇬🇧 EN</div><textarea class="item-desc-en" placeholder="Description EN"></textarea></div>
          <div><div class="lang-label">🇺🇦 UA</div><textarea class="item-desc-ua" placeholder="Опис UA"></textarea></div>
        </div>
      </div>
      <div class="fields-section">
        <div class="fields-section-title">Кількість / склад (необов'язково)</div>
        <div class="lang-row">
          <div><div class="lang-label">🇵🇱 PL</div><input type="text" class="item-count-pl" placeholder="напр. 8szt."></div>
          <div><div class="lang-label">🇬🇧 EN</div><input type="text" class="item-count-en" placeholder="e.g. 8 pcs."></div>
          <div><div class="lang-label">🇺🇦 UA</div><input type="text" class="item-count-ua" placeholder="напр. 8шт."></div>
        </div>
      </div>
      <div class="fields-section rolls-section" style="display:none">
        <div class="fields-section-title">Опис роллів (для наборів)</div>
        <div class="lang-row">
          <div><div class="lang-label">🇵🇱 PL</div><textarea class="item-rolls-pl"></textarea></div>
          <div><div class="lang-label">🇬🇧 EN</div><textarea class="item-rolls-en"></textarea></div>
          <div><div class="lang-label">🇺🇦 UA</div><textarea class="item-rolls-ua"></textarea></div>
        </div>
      </div>
      <button class="btn btn-ghost btn-sm" style="margin-top:6px" onclick="toggleRolls(this)">+ Додати опис роллів</button>
      <div class="fields-section">
        <div class="fields-section-title">Картинка</div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
          <img class="item-img-preview" src="/images/menu/empty.svg" style="width:48px;height:48px" onerror="this.src='/images/menu/empty.svg'">
          <input type="text" class="item-image-url" value="/images/menu/empty.svg" style="flex:1" oninput="updateImgPreview(this)">
        </div>
        <div class="img-upload-row">
          <input type="file" class="item-image-file" accept="image/*" onchange="uploadImage(this)">
          <span class="img-uploading" style="display:none">Завантаження...</span>
        </div>
      </div>
      <input type="hidden" class="item-id" value="${id}">
    </div>`;
  itemsWrap.appendChild(div);
  // update count
  const catBlock = btn.closest('.cat-block');
  catBlock.querySelector('.cat-header-count').textContent =
    catBlock.querySelectorAll('.item-block').length + ' позицій';
  div.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// ── Drag & Drop ───────────────────────────────────────────────────────────────

function initItemsSortable(wrap) {
  Sortable.create(wrap, {
    group: 'items',          // дозволяє переміщувати між категоріями
    handle: '.item-drag-handle',
    animation: 150,
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    dragClass: 'sortable-drag',
    onEnd() { updateAllCounts(); },
  });
}

function updateAllCounts() {
  document.querySelectorAll('#categories-wrap .cat-block').forEach(cat => {
    cat.querySelector('.cat-header-count').textContent =
      cat.querySelectorAll('.item-block').length + ' позицій';
  });
}

function initSortable() {
  // Категорії
  Sortable.create(document.getElementById('categories-wrap'), {
    handle: '.cat-drag-handle',
    animation: 150,
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    dragClass: 'sortable-drag',
  });
  // Позиції у кожній категорії
  document.querySelectorAll('.items-wrap').forEach(initItemsSortable);
}

document.addEventListener('DOMContentLoaded', initSortable);

// ─────────────────────────────────────────────────────────────────────────────

// Upload image
async function uploadImage(input) {
  const block = input.closest('.item-block');
  const statusEl = block.querySelector('.img-uploading');
  statusEl.style.display = 'inline';
  input.disabled = true;

  const fd = new FormData();
  fd.append('image', input.files[0]);
  fd.append('csrf', CSRF);

  try {
    const res = await fetch('/admin/upload.php', { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) {
      block.querySelector('.item-image-url').value = data.url;
      block.querySelectorAll('.item-img-preview').forEach(img => img.src = data.url);
    } else {
      alert('Помилка завантаження: ' + (data.error || 'невідома'));
    }
  } catch {
    alert('Помилка мережі при завантаженні');
  }
  statusEl.style.display = 'none';
  input.disabled = false;
  input.value = '';
}

// Collect data and save
async function saveAll() {
  const statusEl = document.getElementById('save-status');
  statusEl.textContent = 'Збереження...';
  statusEl.className = 'save-status';

  const categories = [];
  document.querySelectorAll('#categories-wrap .cat-block').forEach(catEl => {
    const id = (catEl.querySelector('.cat-title-ua')?.value || '').toLowerCase().replace(/\s+/g, '_') || 'cat_' + Date.now();
    const cat = {
      id,
      title: {
        pl: catEl.querySelector('.cat-title-pl')?.value || '',
        en: catEl.querySelector('.cat-title-en')?.value || '',
        ua: catEl.querySelector('.cat-title-ua')?.value || '',
      },
      items: [],
    };

    catEl.querySelectorAll('.item-block').forEach(itemEl => {
      const countPl = itemEl.querySelector('.item-count-pl')?.value || '';
      const countEn = itemEl.querySelector('.item-count-en')?.value || '';
      const countUa = itemEl.querySelector('.item-count-ua')?.value || '';
      const rollsPl = itemEl.querySelector('.item-rolls-pl')?.value || '';
      const rollsEn = itemEl.querySelector('.item-rolls-en')?.value || '';
      const rollsUa = itemEl.querySelector('.item-rolls-ua')?.value || '';

      const item = {
        id: parseInt(itemEl.querySelector('.item-id')?.value) || 0,
        price: parseInt(itemEl.querySelector('.item-price')?.value) || 0,
        image: itemEl.querySelector('.item-image-url')?.value || '/images/menu/empty.svg',
        name: {
          pl: itemEl.querySelector('.item-name-pl')?.value || '',
          en: itemEl.querySelector('.item-name-en')?.value || '',
          ua: itemEl.querySelector('.item-name-ua')?.value || '',
        },
        description: {
          pl: itemEl.querySelector('.item-desc-pl')?.value || '',
          en: itemEl.querySelector('.item-desc-en')?.value || '',
          ua: itemEl.querySelector('.item-desc-ua')?.value || '',
        },
      };

      if (countPl || countEn || countUa) {
        item.count = { pl: countPl, en: countEn, ua: countUa };
      }
      if (rollsPl || rollsEn || rollsUa) {
        item.rollsDescription = { pl: rollsPl, en: rollsEn, ua: rollsUa };
      }

      cat.items.push(item);
    });

    categories.push(cat);
  });

  try {
    const res = await fetch('/admin/api.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ categories, csrf: CSRF }),
    });
    const data = await res.json();
    if (data.success) {
      statusEl.textContent = '✓ Збережено!';
      statusEl.className = 'save-status ok';
    } else {
      statusEl.textContent = '✗ Помилка: ' + (data.error || 'невідома');
      statusEl.className = 'save-status err';
    }
  } catch (e) {
    statusEl.textContent = '✗ Помилка мережі';
    statusEl.className = 'save-status err';
  }
  setTimeout(() => { statusEl.textContent = ''; statusEl.className = 'save-status'; }, 4000);
}
</script>

<?php endif; ?>
</body>
</html>
