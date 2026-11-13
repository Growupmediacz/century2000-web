<?php /** @var array $files @var string $version */ $last = count($files) - 1; ?>
<section class="adm-stack-lg">
  <div>
    <h1 class="adm-h1">Vzorkovníky ke stažení</h1>
    <p class="adm-muted">PDF katalogy na stránce <a class="adm-link" href="<?= e(url('/vzorkovniky/')) ?>" target="_blank" rel="noopener">Vzorkovníky ↗</a>. Nový soubor se přidá na konec seznamu.</p>
  </div>

  <form class="adm-drop" method="post" enctype="multipart/form-data" action="<?= e(admin_url('catalog-upload')) ?>" data-drop>
    <?= csrf_field() ?>
    <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4"/><path d="M12 18v-6M9 15l3-3 3 3"/></svg>
    <label class="adm-file adm-file--center">
      <input type="file" name="pdf" accept="application/pdf,.pdf" required data-pdf-input>
      <span class="adm-btn adm-btn--ghost">Vybrat PDF z počítače</span>
      <span class="adm-muted" data-file-name>nebo soubor přetáhněte sem (max. 40 MB)</span>
    </label>
    <label class="adm-field adm-drop__title"><span>Název na webu</span>
      <input type="text" name="title" maxlength="120" placeholder="např. T62 · FR Velvet (prázdné = název souboru)"></label>
    <button type="submit" class="adm-btn">Nahrát vzorkovník</button>
  </form>

  <?php if ($files): ?>
  <form method="post" action="<?= e(admin_url('catalog-save')) ?>" class="adm-edit" data-edit-form>
    <?= csrf_field() ?>
    <input type="hidden" name="version" value="<?= e($version) ?>">
    <button type="submit" class="adm-sr" tabindex="-1" aria-hidden="true">Uložit</button>
    <ul class="adm-files">
      <?php foreach ($files as $i => $f): ?>
        <li class="adm-files__row<?= !empty($f['hidden']) ? ' is-hidden' : '' ?>">
          <input type="hidden" name="files[<?= $i ?>][file]" value="<?= e($f['file']) ?>">
          <span class="adm-files__ico" aria-hidden="true">PDF</span>
          <label class="adm-files__name"><span class="adm-sr">Název</span>
            <input type="text" name="files[<?= $i ?>][title]" value="<?= e($f['title']) ?>" maxlength="120"></label>
          <a class="adm-muted" href="<?= e(url($f['file'])) ?>" target="_blank" rel="noopener"><?= e($f['size']) ?> ↗</a>
          <span class="adm-order">
            <button type="submit" name="op" value="up:<?= $i ?>" class="adm-icon-btn" title="Posunout výš" aria-label="Posunout výš" <?= $i === 0 ? 'disabled' : '' ?>>↑</button>
            <button type="submit" name="op" value="down:<?= $i ?>" class="adm-icon-btn" title="Posunout níž" aria-label="Posunout níž" <?= $i === $last ? 'disabled' : '' ?>>↓</button>
          </span>
          <label class="adm-switch"><input type="checkbox" name="files[<?= $i ?>][show]" value="1" <?= empty($f['hidden']) ? 'checked' : '' ?>>
            <span class="adm-switch__track" aria-hidden="true"></span><span>Zobrazit</span></label>
          <label class="adm-delete"><input type="checkbox" name="files[<?= $i ?>][delete]" value="1" data-delete-toggle><span>Smazat</span></label>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="adm-savebar">
      <span class="adm-muted" data-dirty-note hidden>Máte neuložené změny.</span>
      <button type="submit" class="adm-btn">Uložit změny</button>
    </div>
  </form>
  <?php endif; ?>
</section>
