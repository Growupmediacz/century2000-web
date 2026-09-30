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
<body class="adm">
  <header class="adm-top">
    <a class="adm-brand" href="<?= e(admin_url()) ?>"><img src="<?= e(url('/assets/logo/century2000-logo.svg')) ?>" alt="Century 2000"><span>Administrace</span></a>
    <?php if (admin_configured() && admin_logged_in()): ?>
      <nav class="adm-top__nav">
        <a href="<?= e(url('/')) ?>" target="_blank" rel="noopener">Zobrazit web ↗</a>
        <form method="post" action="<?= e(admin_url('logout')) ?>"><?= csrf_field() ?><button type="submit" class="adm-link">Odhlásit</button></form>
      </nav>
    <?php endif; ?>
  </header>
  <main class="adm-main">
    <?php if ($flash): ?>
      <div class="adm-flash adm-flash--<?= e($flash[0]) ?>" role="status"><?= nl2br(e($flash[1])) ?></div>
    <?php endif; ?>
    <?php admin_partial($view, get_defined_vars()); ?>
  </main>
</body>
</html>
