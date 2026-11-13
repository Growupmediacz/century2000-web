<?php /** @var array $refs */ $last = count($refs) - 1; $i = 0; ?>
<section class="adm-stack-lg">
  <div>
    <h1 class="adm-h1">Reference (realizace)</h1>
    <p class="adm-muted">Pořadí platí pro stránku Reference i pro úvodní stránku. Logo a fotky upravíte po kliknutí na „Upravit“.</p>
  </div>
  <form class="adm-newform" id="nova" method="post" action="<?= e(admin_url('new')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="type" value="reference">
    <input type="text" name="title" placeholder="Název nové realizace, např. Hotel Paříž, Praha" required maxlength="120" aria-label="Název nové realizace">
    <button type="submit" class="adm-btn">+ Přidat realizaci</button>
  </form>
  <div class="adm-table" role="table" aria-label="Reference">
    <div class="adm-table__row adm-table__row--head" role="row">
      <span role="columnheader">Pořadí</span><span role="columnheader">Logo</span><span role="columnheader">Hotel / projekt</span>
      <span role="columnheader">Na úvodní stránce</span><span role="columnheader"><span class="adm-sr">Akce</span></span>
    </div>
    <?php foreach ($refs as $name => $r): $logo = page_field($r, 'logo', 'img1')['value']['src'] ?? ''; $hidden = !empty($r['options']['hidden']); ?>
      <div class="adm-table__row<?= $hidden ? ' is-hidden' : '' ?>" role="row" id="ref-<?= e($name) ?>">
        <span role="cell" class="adm-order">
          <?php foreach (['up' => ['↑', 'Posunout výš', $i === 0], 'down' => ['↓', 'Posunout níž', $i === $last]] as $op => [$arrow, $label, $disabled]): ?>
            <form method="post" action="<?= e(admin_url('ref-update')) ?>"><?= csrf_field() ?>
              <input type="hidden" name="page" value="<?= e($name) ?>"><input type="hidden" name="op" value="<?= $op ?>">
              <button type="submit" class="adm-icon-btn" title="<?= $label ?>" aria-label="<?= $label ?>: <?= e($r['name']) ?>" <?= $disabled ? 'disabled' : '' ?>><?= $arrow ?></button>
            </form>
          <?php endforeach; ?>
        </span>
        <span role="cell"><?php if ($logo !== ''): ?><img class="adm-logo-thumb" src="<?= e(url($logo)) ?>" alt=""><?php else: ?><span class="adm-logo-thumb adm-logo-thumb--empty">bez loga</span><?php endif; ?></span>
        <span role="cell" class="adm-table__name">
          <a class="adm-list__title adm-list__title--sm" href="<?= e(admin_url('edit', ['page' => $name])) ?>"><?= e($r['name']) ?></a>
          <?php if ($hidden): ?><span class="adm-chip adm-chip--off">Skrytá</span><?php endif; ?>
        </span>
        <span role="cell">
          <form method="post" action="<?= e(admin_url('ref-update')) ?>" data-autosubmit><?= csrf_field() ?>
            <input type="hidden" name="page" value="<?= e($name) ?>"><input type="hidden" name="op" value="featured">
            <input type="hidden" name="value" value="0">
            <label class="adm-switch"><input type="checkbox" name="value" value="1" <?= !empty($r['options']['featured']) ? 'checked' : '' ?>>
              <span class="adm-switch__track" aria-hidden="true"></span><span class="adm-sr">Zobrazit <?= e($r['name']) ?> na úvodní stránce</span></label>
            <noscript><button type="submit" class="adm-link">Uložit</button></noscript>
          </form>
        </span>
        <span role="cell"><a class="adm-link" href="<?= e(admin_url('edit', ['page' => $name])) ?>">Upravit</a></span>
      </div>
    <?php $i++; endforeach; ?>
  </div>
</section>
