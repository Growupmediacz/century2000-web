<?php
/** @var string $name @var array $doc @var array $data @var string $version */
$fieldId = fn(string $s, string $f) => 'f-' . $s . '-' . $f;
?>
<form class="adm-edit" method="post" enctype="multipart/form-data" action="<?= e(admin_url('save', ['page' => $name])) ?>" data-edit-form>
  <?= csrf_field() ?>
  <input type="hidden" name="version" value="<?= e($version) ?>">

  <div class="adm-edit__head">
    <a class="adm-link" href="<?= e(admin_url()) ?>">← Všechny stránky</a>
    <h1 class="adm-h1"><?= e($doc['label']) ?></h1>
    <p class="adm-muted">
      <?php if ($doc['path']): ?><a class="adm-link" href="<?= e(url($doc['path'])) ?>" target="_blank" rel="noopener">Zobrazit stránku ↗</a> · <?php endif; ?>
      <a class="adm-link" href="<?= e(admin_url('history', ['page' => $name])) ?>">Historie verzí</a>
    </p>
  </div>

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

  <?php foreach ($data['sections'] as $i => $section): $sk = $section['key']; ?>
    <details class="adm-section<?= empty($section['visible']) ? ' is-hidden' : '' ?>" <?= $i === 0 ? 'open' : '' ?>>
      <summary class="adm-section__head">
        <span class="adm-section__title"><?= e($section['label']) ?></span>
        <span class="adm-badge" data-hidden-badge <?= empty($section['visible']) ? '' : 'hidden' ?>>Skrytá</span>
        <span class="adm-muted"><?= count($section['fields']) ?> polí</span>
      </summary>
      <div class="adm-section__body">
        <?php if (!empty($section['hideable'])): ?>
          <div class="adm-switch-row">
            <input type="hidden" name="visible[<?= e($sk) ?>]" value="0">
            <label class="adm-switch">
              <input type="checkbox" name="visible[<?= e($sk) ?>]" value="1" <?= empty($section['visible']) ? '' : 'checked' ?> data-visible-toggle>
              <span class="adm-switch__track" aria-hidden="true"></span>
              <span>Zobrazit sekci na webu</span>
            </label>
          </div>
        <?php endif; ?>

        <?php foreach ($section['fields'] as $field): $fk = $field['key']; $id = $fieldId($sk, $fk); ?>
          <?php if ($field['type'] === 'text'): $long = mb_strlen((string) $field['value']) > 90; ?>
            <label class="adm-field" for="<?= e($id) ?>"><span><?= e($field['label']) ?></span>
              <?php if ($long): ?>
                <textarea id="<?= e($id) ?>" name="f[<?= e($sk) ?>][<?= e($fk) ?>]" rows="<?= min(8, 2 + (int) (mb_strlen((string) $field['value']) / 90)) ?>"><?= e($field['value']) ?></textarea>
              <?php else: ?>
                <input id="<?= e($id) ?>" type="text" name="f[<?= e($sk) ?>][<?= e($fk) ?>]" value="<?= e($field['value']) ?>">
              <?php endif; ?>
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
            </div>
          <?php elseif ($field['type'] === 'image'): ?>
            <div class="adm-field adm-image">
              <span><?= e($field['label']) ?></span>
              <div class="adm-image__row">
                <img class="adm-image__preview" src="<?= e(url($field['value']['src'])) ?>" alt="" data-preview>
                <div class="adm-stack">
                  <label class="adm-file">
                    <input type="file" name="img[<?= e($sk) ?>][<?= e($fk) ?>]" accept="image/jpeg,image/png,image/webp" data-image-input>
                    <span class="adm-btn adm-btn--ghost">Vyměnit obrázek</span>
                    <span class="adm-muted" data-file-name>JPG, PNG nebo WebP, max. 20 MB. Zmenší se automaticky.</span>
                  </label>
                  <label class="adm-field"><span>Popis obrázku (pro nevidomé a Google)</span>
                    <input type="text" name="alt[<?= e($sk) ?>][<?= e($fk) ?>]" value="<?= e($field['value']['alt']) ?>"></label>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </details>
  <?php endforeach; ?>

  <div class="adm-savebar">
    <span class="adm-muted" data-dirty-note hidden>Máte neuložené změny.</span>
    <button type="submit" class="adm-btn">Uložit změny</button>
  </div>
</form>
