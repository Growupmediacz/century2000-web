<section class="adm-stack-lg">
  <div>
    <a class="adm-link" href="<?= e(admin_url('edit', ['page' => $name])) ?>">← Zpět na úpravy</a>
    <h1 class="adm-h1"><?= e($title) ?></h1>
    <p class="adm-muted">Před každým uložením se ukládá předchozí verze (posledních 30). Obnovením se vrátí celá stránka do stavu z daného času.</p>
  </div>
  <?php if (!$backups): ?>
    <p class="adm-card">Zatím žádné předchozí verze.</p>
  <?php else: ?>
    <ul class="adm-list">
      <?php foreach ($backups as $b): ?>
        <li class="adm-list__item">
          <span class="adm-list__main"><span class="adm-list__title"><?= e(date('j. n. Y H:i:s', $b['time'])) ?></span></span>
          <form method="post" action="<?= e(admin_url('restore', ['page' => $name])) ?>" data-confirm="Obnovit verzi z <?= e(date('j. n. Y H:i', $b['time'])) ?>?">
            <?= csrf_field() ?>
            <input type="hidden" name="backup" value="<?= e($b['file']) ?>">
            <button type="submit" class="adm-btn adm-btn--ghost">Obnovit</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>
