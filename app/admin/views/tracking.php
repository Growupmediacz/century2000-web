<?php
/** @var array $t @var array $errors */
$cats = ['necessary' => 'Nezbytný (spustí se vždy)', 'analytics' => 'Analytický (po souhlasu s analytickými cookies)', 'marketing' => 'Marketingový (po souhlasu s marketingovými cookies)'];
?>
<form class="adm-edit" method="post" action="<?= e(admin_url('tracking-save')) ?>" data-edit-form>
  <?= csrf_field() ?>
  <div class="adm-edit__head">
    <h1 class="adm-h1">Měřicí kódy</h1>
    <p class="adm-muted">Google Analytics, Google Ads, Meta Pixel, Sklik a další kódy. Žádný z nich se nespustí, dokud návštěvník v liště cookies nedá souhlas s příslušnou kategorií (Google Consent Mode v2). Zásady cookies na webu se podle vyplněných nástrojů doplní samy.</p>
  </div>

  <section class="adm-section adm-section--plain" aria-labelledby="h-mode">
    <div class="adm-section__body adm-section__body--plain">
      <h2 class="adm-h1 adm-h1--card" id="h-mode">Režim souhlasu (Consent Mode v2)</h2>
      <label class="adm-radio"><input type="radio" name="mode" value="basic" <?= $t['mode'] !== 'advanced' ? 'checked' : '' ?>>
        <span><strong>Základní (doporučeno)</strong><br><span class="adm-help">Kódy Googlu se načtou až po souhlasu. Bez souhlasu Google nedostane nic. Nejbezpečnější varianta podle evropských pravidel.</span></span></label>
      <label class="adm-radio"><input type="radio" name="mode" value="advanced" <?= $t['mode'] === 'advanced' ? 'checked' : '' ?>>
        <span><strong>Pokročilý</strong><br><span class="adm-help">Kódy Googlu se načtou hned, ale bez souhlasu neukládají cookies a posílají jen anonymní signály. Google z nich dopočítá chybějící konverze. Zapněte jen po dohodě s tím, kdo odpovídá za ochranu osobních údajů.</span></span></label>
    </div>
  </section>

  <section class="adm-section adm-section--plain" aria-labelledby="h-ids">
    <div class="adm-section__body adm-section__body--plain">
      <h2 class="adm-h1 adm-h1--card" id="h-ids">Nástroje</h2>
      <?php foreach (TRACKING_IDS as $key => [$label, , $help]): ?>
        <label class="adm-field"><span><?= e($label) ?></span>
          <input type="text" name="<?= e($key) ?>" value="<?= e((string) $t[$key]) ?>" autocomplete="off" spellcheck="false" placeholder="nevyplněno = nepoužívá se">
          <?php if (isset($errors[$key])): ?><small class="adm-error"><?= e($errors[$key]) ?></small><?php endif; ?>
          <small class="adm-help"><?= e($help) ?></small></label>
      <?php endforeach; ?>
    </div>
  </section>

  <?php foreach ($t['custom'] as $i => $c): ?>
    <details class="adm-section" <?= trim((string) $c['code']) !== '' ? 'open' : '' ?>>
      <summary class="adm-section__head"><span class="adm-section__title">Vlastní kód <?= $i + 1 ?><?= $c['label'] !== '' ? ': ' . e($c['label']) : '' ?></span><span class="adm-muted"><?= trim((string) $c['code']) !== '' ? 'aktivní' : 'prázdný' ?></span></summary>
      <div class="adm-section__body">
        <p class="adm-note">Pro kód, který tu výše není (např. Hotjar, LinkedIn, Heureka). Vložte ho celý tak, jak ho nástroj dává, včetně &lt;script&gt;. Kód se spustí až po souhlasu s vybranou kategorií. Vkládejte jen kódy z důvěryhodných zdrojů.</p>
        <label class="adm-field"><span>Název nástroje (ukáže se v Zásadách cookies)</span>
          <input type="text" name="custom[<?= $i ?>][label]" value="<?= e($c['label']) ?>" maxlength="120"></label>
        <label class="adm-field"><span>Kategorie souhlasu</span>
          <select name="custom[<?= $i ?>][category]"><?php foreach ($cats as $k => $l): ?><option value="<?= $k ?>" <?= $c['category'] === $k ? 'selected' : '' ?>><?= e($l) ?></option><?php endforeach; ?></select></label>
        <label class="adm-field"><span>Umístění</span>
          <select name="custom[<?= $i ?>][place]"><option value="head" <?= $c['place'] === 'head' ? 'selected' : '' ?>>v hlavičce stránky (&lt;head&gt;)</option><option value="body" <?= $c['place'] !== 'head' ? 'selected' : '' ?>>na konci stránky (před &lt;/body&gt;)</option></select></label>
        <label class="adm-field"><span>Kód</span>
          <textarea name="custom[<?= $i ?>][code]" rows="7" class="adm-code-input" spellcheck="false"><?= e($c['code']) ?></textarea></label>
      </div>
    </details>
  <?php endforeach; ?>

  <div class="adm-savebar">
    <?php if ($t['updated'] !== ''): ?><span class="adm-muted">Naposledy uloženo <?= e(date('j. n. Y H:i', strtotime($t['updated']))) ?></span><?php endif; ?>
    <span class="adm-savebar__spacer"></span>
    <span class="adm-muted" data-dirty-note hidden>Máte neuložené změny.</span>
    <button type="submit" class="adm-btn">Uložit změny</button>
  </div>
</form>
