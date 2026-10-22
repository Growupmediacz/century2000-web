<?php
/** @var string $title @var string|null $nav */
$icons = [
    'dashboard' => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>',
    'pages' => '<path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4"/>',
    'index' => '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/><path d="M10 20v-6h4v6"/>',
    'refs' => '<path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9z"/>',
    'articles' => '<rect x="4" y="4" width="16" height="16"/><path d="M8 9h8M8 13h8M8 17h5"/>',
    'catalogs' => '<path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4"/><path d="M9 14h6M9 17h4"/>',
    'global' => '<rect x="3" y="5" width="18" height="14"/><path d="M3 7l9 6 9-6"/>',
    'settings' => '<circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.9 4.9l2.1 2.1M17 17l2.1 2.1M4.9 19.1L7 17M17 7l2.1-2.1"/>',
];
$menu = [
    'dashboard' => ['Přehled', admin_url()],
    'pages' => ['Stránky', admin_url('pages')],
    'index' => ['Úvodní stránka', admin_url('edit', ['page' => 'index'])],
    'refs' => ['Reference', admin_url('refs')],
    'articles' => ['Články', admin_url('articles')],
    'catalogs' => ['Vzorkovníky', admin_url('catalogs')],
    'global' => ['Patička a kontakty', admin_url('edit', ['page' => 'global'])],
    'settings' => ['Nastavení', admin_url('settings')],
];
$withNav = $nav !== null && admin_configured() && admin_logged_in();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title><?= e($title) ?> · Administrace Century 2000</title>
  <link rel="icon" type="image/png" href="<?= e(url('/assets/favicon-32x32.png')) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&amp;family=Playfair+Display:wght@500&amp;display=swap">
  <link rel="stylesheet" href="<?= e(url('/admin/admin.css')) ?>?v=<?= e((string) filemtime(PUBLIC_DIR . '/admin/admin.css')) ?>">
  <script src="<?= e(url('/admin/admin.js')) ?>?v=<?= e((string) filemtime(PUBLIC_DIR . '/admin/admin.js')) ?>" defer></script>
</head>
<body class="adm<?= $withNav ? ' adm--nav' : '' ?>">
  <header class="adm-top">
    <a class="adm-brand" href="<?= e(admin_url()) ?>"><img src="<?= e(url('/assets/logo/century2000-logo.svg')) ?>" alt="Century 2000"><span>Administrace</span></a>
    <?php if ($withNav): ?>
      <nav class="adm-top__nav">
        <a href="<?= e(url('/')) ?>" target="_blank" rel="noopener">Zobrazit web ↗</a>
        <form method="post" action="<?= e(admin_url('logout')) ?>"><?= csrf_field() ?><button type="submit" class="adm-link">Odhlásit</button></form>
      </nav>
    <?php endif; ?>
  </header>
  <div class="adm-shell">
    <?php if ($withNav): ?>
      <nav class="adm-side" aria-label="Administrace">
        <ul>
          <?php foreach ($menu as $key => [$label, $href]): ?>
            <li><a class="adm-side__link<?= $nav === $key ? ' is-active' : '' ?>" href="<?= e($href) ?>"<?= $nav === $key ? ' aria-current="page"' : '' ?>>
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $icons[$key] ?></svg>
              <span><?= e($label) ?></span></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
    <?php endif; ?>
    <main class="adm-main">
      <?php if ($flash): ?>
        <div class="adm-flash adm-flash--<?= e($flash[0]) ?>" role="status"><?= nl2br(e($flash[1])) ?></div>
      <?php endif; ?>
      <?php admin_partial($view, get_defined_vars()); ?>
    </main>
  </div>
</body>
</html>
