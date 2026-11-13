<?php
/** @var array $recent @var int $backups @var int $lastBackup */
$tiles = [
    [admin_url('edit', ['page' => 'index']), 'Upravit úvodní stránku', '<rect x="3" y="4" width="18" height="12"/><path d="M8 20h8M12 16v4"/>'],
    [admin_url('refs') . '#nova', 'Přidat referenci', '<path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9z"/>'],
    [admin_url('articles') . '#novy', 'Napsat článek', '<path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4"/><path d="M9 13h6M9 16h4"/>'],
    [admin_url('catalogs'), 'Nahrát vzorkovník (PDF)', '<path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4"/><text x="12" y="17" font-size="5.5" text-anchor="middle" fill="currentColor" stroke="none" font-family="Barlow, sans-serif" font-weight="600">PDF</text>'],
];
$hour = (int) date('G');
?>
<section class="adm-stack-lg">
  <h1 class="adm-h1"><?= $hour < 10 ? 'Dobré ráno' : 'Dobrý den' ?>, co chcete dnes upravit?</h1>

  <div class="adm-tiles">
    <?php foreach ($tiles as [$href, $label, $icon]): ?>
      <a class="adm-tile" href="<?= e($href) ?>">
        <svg viewBox="0 0 24 24" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $icon ?></svg>
        <span><?= e($label) ?></span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="adm-cols">
    <section class="adm-card adm-cols__main" aria-labelledby="h-recent">
      <h2 class="adm-h1 adm-h1--card" id="h-recent">Naposledy upraveno</h2>
      <ul class="adm-list">
        <?php foreach ($recent as $name => $doc): ?>
          <li class="adm-list__item">
            <a class="adm-list__main" href="<?= e(admin_url('edit', ['page' => $name])) ?>">
              <span class="adm-list__title adm-list__title--sm"><?= e($doc['label']) ?></span>
              <span class="adm-muted"><?= e(date('j. n. Y H:i', $doc['mtime'])) ?></span>
            </a>
            <a class="adm-link" href="<?= e(admin_url('edit', ['page' => $name])) ?>">Upravit</a>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>
    <section class="adm-card adm-cols__side" aria-labelledby="h-state">
      <h2 class="adm-h1 adm-h1--card" id="h-state">Stav webu</h2>
      <ul class="adm-state">
        <?php if (config('demo')): ?>
          <li class="is-warn">Web je skrytý před vyhledávači (testovací režim)</li>
        <?php else: ?>
          <li>Web je zveřejněný a viditelný pro Google</li>
        <?php endif; ?>
        <li><?= $lastBackup ? 'Poslední záloha: ' . e(date('j. n. Y H:i', $lastBackup)) : 'Zatím žádná záloha (vznikne při prvním uložení)' ?></li>
        <li><?= (int) $backups ?> uložených verzí v historii</li>
        <?php if (config('mail.transport') === 'log'): ?>
          <li class="is-warn">Poptávky se neodesílají e-mailem (testovací režim)</li>
        <?php endif; ?>
      </ul>
    </section>
  </div>
</section>
