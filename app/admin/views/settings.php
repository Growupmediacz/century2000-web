<section class="adm-stack-lg">
  <h1 class="adm-h1">Nastavení</h1>
  <div class="adm-cols">
    <section class="adm-card adm-cols__main" aria-labelledby="h-pass">
      <h2 class="adm-h1 adm-h1--card" id="h-pass">Změna hesla</h2>
      <form method="post" action="<?= e(admin_url('password')) ?>" class="adm-stack">
        <?= csrf_field() ?>
        <input type="text" name="user" value="<?= e((string) config('admin.user')) ?>" autocomplete="username" hidden>
        <label class="adm-field"><span>Současné heslo</span><input type="password" name="current" autocomplete="current-password" required></label>
        <label class="adm-field"><span>Nové heslo <span class="adm-count">aspoň 10 znaků</span></span><input type="password" name="new" autocomplete="new-password" minlength="10" required></label>
        <label class="adm-field"><span>Nové heslo znovu</span><input type="password" name="again" autocomplete="new-password" minlength="10" required></label>
        <div><button type="submit" class="adm-btn adm-btn--ghost">Změnit heslo</button></div>
      </form>
    </section>
    <section class="adm-card adm-cols__side" aria-labelledby="h-help">
      <h2 class="adm-h1 adm-h1--card" id="h-help">Kde co upravit</h2>
      <ul class="adm-help-list">
        <li><strong>Telefon, e-mail, adresa</strong> v patičce: <a class="adm-link" href="<?= e(admin_url('edit', ['page' => 'global'])) ?>">Patička a kontakty</a></li>
        <li><strong>Kontaktní stránka:</strong> <a class="adm-link" href="<?= e(admin_url('edit', ['page' => 'kontakt'])) ?>">Kontakt</a></li>
        <li><strong>Kam chodí poptávky z formuláře</strong> nastavuje vývojář (soubor config.php na serveru).</li>
        <li><strong>Omylem smazaný text?</strong> Každá stránka má odkaz „Historie verzí“ a umí se vrátit o 30 uložení zpět.</li>
      </ul>
    </section>
  </div>
</section>
