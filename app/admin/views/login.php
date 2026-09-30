<section class="adm-card adm-narrow">
  <h1 class="adm-h1">Přihlášení</h1>
  <?php if ($error): ?><p class="adm-error" role="alert"><?= e($error) ?></p><?php endif; ?>
  <form method="post" action="<?= e(admin_url('login')) ?>" class="adm-stack">
    <?= csrf_field() ?>
    <label class="adm-field"><span>Uživatelské jméno</span><input type="text" name="user" autocomplete="username" required autofocus></label>
    <label class="adm-field"><span>Heslo</span><input type="password" name="password" autocomplete="current-password" required></label>
    <button type="submit" class="adm-btn">Přihlásit se</button>
  </form>
</section>
