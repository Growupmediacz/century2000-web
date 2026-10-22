<?php
/** @var string $name @var array $doc @var array $data @var string $version @var array $options @var bool $blocks @var string $open */
$fieldId = fn(string $s, string $f) => 'f-' . $s . '-' . $f;
$isBlock = fn(array $s) => $blocks && (bool) preg_match('/^(blok|foto|tip)-/', $s['key']);
$blockKeys = array_values(array_filter(array_column($data['sections'], 'key'), fn($k) => $blocks && preg_match('/^(blok|foto|tip)-/', $k)));
// Block title: its type, plus the subheading/caption so the client recognises it when collapsed
$blockTitle = function (array $s): string {
    $type = BLOCK_TYPES[explode('-', $s['key'])[0]] ?? $s['label'];
    $first = '';
    foreach ($s['fields'] as $f) {
        if ($f['type'] === 'text' && trim((string) $f['value']) !== '') {
            $first = (string) $f['value'];
            break;
        }
    }
    return $first !== '' ? $type . ': ' . mb_strimwidth($first, 0, 60, '…') : $type;
};
$visibleOpt = null;
foreach ($options as $k => $o) {
    if ($o[1] === 'visible') {
        $visibleOpt = $k;
    }
}
?>
<form class="adm-edit" method="post" enctype="multipart/form-data" action="<?= e(admin_url('save', ['page' => $name])) ?>" data-edit-form>
  <?= csrf_field() ?>
  <input type="hidden" name="version" value="<?= e($version) ?>">
  <?php /* Enter in a text field submits with the first button in the form: make it plain "save", not a block action */ ?>
  <button type="submit" class="adm-sr" tabindex="-1" aria-hidden="true">Uložit</button>

  <div class="adm-edit__head">
    <a class="adm-link" href="<?= e(match ($doc['group']) { 'articles' => admin_url('articles'), 'references' => admin_url('refs'), default => admin_url('pages') }) ?>">← <?= e(match ($doc['group']) { 'articles' => 'Všechny články', 'references' => 'Všechny reference', default => 'Všechny stránky' }) ?></a>
    <div class="adm-head-row">
      <h1 class="adm-h1"><?= e($doc['label']) ?></h1>
      <?php if ($visibleOpt): $on = empty($data['options']['hidden']); ?>
        <div class="adm-publish">
          <span class="adm-chip<?= $on ? '' : ' adm-chip--off' ?>" data-publish-chip><?= $on ? 'Na webu' : 'Skryto' ?></span>
          <input type="hidden" name="opt[<?= e($visibleOpt) ?>]" value="0">
          <label class="adm-switch"><input type="checkbox" name="opt[<?= e($visibleOpt) ?>]" value="1" <?= $on ? 'checked' : '' ?> data-publish-toggle>
            <span class="adm-switch__track" aria-hidden="true"></span><span><?= e($options[$visibleOpt][0]) ?></span></label>
        </div>
      <?php endif; ?>
    </div>
    <p class="adm-muted">
      <?php if ($doc['path'] && !$doc['hidden']): ?><a class="adm-link" href="<?= e(url($doc['path'])) ?>" target="_blank" rel="noopener">Zobrazit stránku ↗</a> · <?php endif; ?>
      <a class="adm-link" href="<?= e(admin_url('history', ['page' => $name])) ?>">Historie verzí</a>
    </p>
  </div>

  <?php $rest = array_filter($options, fn($o) => $o[1] !== 'visible'); if ($rest): ?>
    <div class="adm-section adm-section--plain">
      <div class="adm-section__body adm-section__body--plain">
        <?php foreach ($rest as $key => [$label, $type, $help]): ?>
          <?php if ($type === 'bool'): ?>
            <div class="adm-field">
              <input type="hidden" name="opt[<?= e($key) ?>]" value="0">
              <label class="adm-switch"><input type="checkbox" name="opt[<?= e($key) ?>]" value="1" <?= !empty($data['options'][$key]) ? 'checked' : '' ?>>
                <span class="adm-switch__track" aria-hidden="true"></span><span><?= e($label) ?></span></label>
              <small class="adm-help"><?= e($help) ?></small>
            </div>
          <?php elseif ($type === 'date'): ?>
            <label class="adm-field adm-field--narrow"><span><?= e($label) ?></span>
              <input type="date" name="opt[<?= e($key) ?>]" value="<?= e((string) ($data['options'][$key] ?? '')) ?>">
              <small class="adm-help"><?= e($help) ?></small></label>
          <?php elseif ($type === 'services'): $sel = (array) ($data['options'][$key] ?? []); ?>
            <fieldset class="adm-field adm-checks"><legend><?= e($label) ?></legend>
              <input type="hidden" name="opt_present[<?= e($key) ?>]" value="1">
              <?php foreach (SERVICE_PAGES as $path => $svc): ?>
                <label><input type="checkbox" name="opt[<?= e($key) ?>][]" value="<?= e($path) ?>" <?= in_array($path, $sel, true) ? 'checked' : '' ?>> <?= e($svc) ?></label>
              <?php endforeach; ?>
              <small class="adm-help"><?= e($help) ?></small>
            </fieldset>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if (isset($data['meta'])): ?>
    <details class="adm-section">
      <summary class="adm-section__head"><span class="adm-section__title">Vyhledávače (SEO)</span><span class="adm-muted">titulek a popis ve výsledcích Googlu</span></summary>
      <div class="adm-section__body">
        <label class="adm-field"><span>Titulek stránky</span>
          <input type="text" name="meta[title]" value="<?= e($data['meta']['title']) ?>" maxlength="200" data-count="60"></label>
        <label class="adm-field"><span>Popis</span>
          <textarea name="meta[description]" rows="3" maxlength="400" data-count="160"><?= e($data['meta']['description']) ?></textarea></label>
      </div>
    </details>
  <?php endif; ?>

  <?php foreach ($data['sections'] as $i => $section): $sk = $section['key']; $block = $isBlock($section); $bi = $block ? array_search($sk, $blockKeys, true) : false;
    $isOpen = $open !== '' ? $open === $sk : $i === 0; ?>
    <details class="adm-section<?= empty($section['visible']) ? ' is-hidden' : '' ?><?= $block ? ' adm-section--block' : '' ?>" id="s-<?= e($sk) ?>" <?= $isOpen ? 'open' : '' ?>>
      <summary class="adm-section__head">
        <span class="adm-section__title"><?= e($block ? $blockTitle($section) : $section['label']) ?></span>
        <span class="adm-badge" data-hidden-badge <?= empty($section['visible']) ? '' : 'hidden' ?>>Skrytá</span>
        <?php if ($block): ?>
          <span class="adm-order">
            <button type="submit" name="op" value="up:<?= e($sk) ?>" class="adm-icon-btn" title="Posunout výš" aria-label="Posunout blok výš" <?= $bi === 0 ? 'disabled' : '' ?>>↑</button>
            <button type="submit" name="op" value="down:<?= e($sk) ?>" class="adm-icon-btn" title="Posunout níž" aria-label="Posunout blok níž" <?= $bi === count($blockKeys) - 1 ? 'disabled' : '' ?>>↓</button>
            <button type="submit" name="op" value="del:<?= e($sk) ?>" class="adm-icon-btn adm-icon-btn--danger" title="Odstranit blok" aria-label="Odstranit blok" data-confirm-click="Opravdu odstranit tento blok? (Půjde vrátit v Historii verzí.)">✕</button>
          </span>
        <?php else: ?>
          <span class="adm-muted"><?= count($section['fields']) ?> <?= count($section['fields']) === 1 ? 'pole' : (count($section['fields']) < 5 ? 'pole' : 'polí') ?></span>
        <?php endif; ?>
      </summary>
      <div class="adm-section__body">
        <?php if (!empty($section['note'])): ?><p class="adm-note"><?= e($section['note']) ?></p><?php endif; ?>
        <?php if (!empty($section['hideable'])): ?>
          <div class="adm-switch-row">
            <input type="hidden" name="visible[<?= e($sk) ?>]" value="0">
            <label class="adm-switch">
              <input type="checkbox" name="visible[<?= e($sk) ?>]" value="1" <?= empty($section['visible']) ? '' : 'checked' ?> data-visible-toggle>
              <span class="adm-switch__track" aria-hidden="true"></span>
              <span><?= $block ? 'Zobrazit blok na webu' : 'Zobrazit sekci na webu' ?></span>
            </label>
          </div>
        <?php endif; ?>

        <?php foreach ($section['fields'] as $field): $fk = $field['key']; $id = $fieldId($sk, $fk); $help = (string) ($field['help'] ?? ''); ?>
          <?php if ($field['type'] === 'text'):
            $val = (string) $field['value'];
            $long = !empty($field['multiline']) || mb_strlen($val) > 90 || str_contains($val, "\n"); ?>
            <label class="adm-field" for="<?= e($id) ?>"><span><?= e($field['label']) ?></span>
              <?php if ($long): ?>
                <textarea id="<?= e($id) ?>" name="f[<?= e($sk) ?>][<?= e($fk) ?>]" rows="<?= max(2, min(8, substr_count($val, "\n") + 1 + (int) (mb_strlen($val) / 90))) ?>"><?= e($val) ?></textarea>
              <?php else: ?>
                <input id="<?= e($id) ?>" type="text" name="f[<?= e($sk) ?>][<?= e($fk) ?>]" value="<?= e($val) ?>">
              <?php endif; ?>
              <?php if ($help !== ''): ?><small class="adm-help"><?= e($help) ?></small><?php endif; ?>
            </label>
          <?php elseif ($field['type'] === 'rich'): ?>
            <div class="adm-field">
              <span id="<?= e($id) ?>-label"><?= e($field['label']) ?></span>
              <div class="adm-rte">
                <div class="adm-rte__bar" role="toolbar" aria-label="Formátování">
                  <button type="button" data-cmd="bold" title="Tučně"><strong>B</strong></button>
                  <button type="button" data-cmd="italic" title="Kurzíva"><em>I</em></button>
                  <button type="button" data-cmd="link" title="Odkaz">Odkaz</button>
                  <button type="button" data-cmd="unlink" title="Zrušit odkaz">Zrušit odkaz</button>
                  <button type="button" data-cmd="removeFormat" title="Zrušit formátování">Bez formátu</button>
                </div>
                <div class="adm-rte__area" contenteditable="true" role="textbox" aria-multiline="true" aria-labelledby="<?= e($id) ?>-label" data-rte><?= $field['value'] ?></div>
                <input type="hidden" name="f[<?= e($sk) ?>][<?= e($fk) ?>]" value="<?= e($field['value']) ?>" data-rte-input>
              </div>
              <?php if ($help !== ''): ?><small class="adm-help"><?= e($help) ?></small><?php endif; ?>
            </div>
          <?php elseif ($field['type'] === 'image'): $src = (string) ($field['value']['src'] ?? ''); ?>
            <div class="adm-field adm-image">
              <span><?= e($field['label']) ?></span>
              <div class="adm-image__row">
                <?php if ($src !== ''): ?>
                  <img class="adm-image__preview<?= !empty($field['optional']) ? ' adm-image__preview--contain' : '' ?>" src="<?= e(url($src)) ?>" alt="" data-preview>
                <?php else: ?>
                  <span class="adm-image__preview adm-image__preview--empty" data-preview-empty>Bez obrázku</span>
                  <img class="adm-image__preview adm-image__preview--contain" src="" alt="" data-preview hidden>
                <?php endif; ?>
                <div class="adm-stack">
                  <label class="adm-file">
                    <input type="file" name="img[<?= e($sk) ?>][<?= e($fk) ?>]" accept="image/jpeg,image/png,image/webp" data-image-input>
                    <span class="adm-btn adm-btn--ghost"><?= $src === '' ? 'Nahrát obrázek' : 'Vyměnit obrázek' ?></span>
                    <span class="adm-muted" data-file-name>JPG, PNG nebo WebP, max. 20 MB. Zmenší se automaticky.</span>
                  </label>
                  <?php if (!empty($field['optional']) && $src !== ''): ?>
                    <label class="adm-delete"><input type="checkbox" name="remove[<?= e($sk) ?>][<?= e($fk) ?>]" value="1"><span>Odstranit obrázek</span></label>
                  <?php endif; ?>
                  <label class="adm-field"><span>Popis obrázku (pro nevidomé a Google)</span>
                    <input type="text" name="alt[<?= e($sk) ?>][<?= e($fk) ?>]" value="<?= e($field['value']['alt'] ?? '') ?>"></label>
                  <?php if ($help !== ''): ?><small class="adm-help"><?= e($help) ?></small><?php endif; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </details>
    <?php if ($block && $bi === count($blockKeys) - 1): ?>
      <div class="adm-addbar" id="pridat-blok">
        <span>Přidat blok:</span>
        <?php foreach (BLOCK_TYPES as $type => $label): ?>
          <button type="submit" name="op" value="add:<?= $type ?>:<?= e($sk) ?>" class="adm-btn adm-btn--ghost adm-btn--sm">+ <?= e($label) ?></button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>
  <?php if ($blocks && !$blockKeys): ?>
    <div class="adm-addbar">
      <span>Přidat blok:</span>
      <?php foreach (BLOCK_TYPES as $type => $label): ?>
        <button type="submit" name="op" value="add:<?= $type ?>" class="adm-btn adm-btn--ghost adm-btn--sm">+ <?= e($label) ?></button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="adm-savebar">
    <?php if (in_array($doc['group'], ['articles', 'references'], true)): ?>
      <button type="submit" form="delete-form" class="adm-link adm-link--danger" data-confirm-click="Opravdu smazat „<?= e($doc['label']) ?>“? Zmizí z webu i z administrace.">Smazat <?= $doc['group'] === 'articles' ? 'článek' : 'referenci' ?></button>
    <?php endif; ?>
    <span class="adm-savebar__spacer"></span>
    <span class="adm-muted" data-dirty-note hidden>Máte neuložené změny.</span>
    <button type="submit" class="adm-btn">Uložit změny</button>
  </div>
</form>
<?php if (in_array($doc['group'], ['articles', 'references'], true)): ?>
  <form id="delete-form" method="post" action="<?= e(admin_url('delete')) ?>" hidden><?= csrf_field() ?><input type="hidden" name="page" value="<?= e($name) ?>"></form>
<?php endif; ?>
