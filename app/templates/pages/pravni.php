<?php
/*
 * Legal page (Zásady ochrany osobních údajů, Zásady cookies). Sections, in file order:
 *   uvod          H1 (t1) + perex (r1)
 *   oddil-*       heading (t1) + text (r1, paragraphs separated by an empty line)
 *   ucel-*        one row of the "purposes" table: t1 purpose, t2 data, t3 legal basis, t4 retention
 *                 (consecutive rows are rendered as one table)
 *   cookies       table of cookies generated from the measurement codes set in the admin (tracking_cookie_rows)
 *   tlacitko      button that opens the cookie settings (t1)
 */
$cookieCats = ['necessary' => 'Nezbytné', 'analytics' => 'Analytické', 'marketing' => 'Marketingové'];
$rowsOpen = false;
$closeRows = function () use (&$rowsOpen) {
    if ($rowsOpen) {
        echo "</tbody></table>\n";
        $rowsOpen = false;
    }
};
?>
<div class="page">
  <?php partial('header'); ?>
  <main>
    <section class="pravni" aria-labelledby="hero-h1">
      <div class="container pravni__inner">
        <article class="pravni__box">
          <?php foreach ($page['sections'] as $s): if (empty($s['visible'])) continue;
            $f = array_column($s['fields'], 'value', 'key');
            $key = $s['key'];
            if (!str_starts_with($key, 'ucel-')) { $closeRows(); } ?>
            <?php if ($key === 'uvod'): ?>
              <header class="pravni__head">
                <span class="rule" aria-hidden="true"></span>
                <h1 class="title-hero pravni__title" id="hero-h1"><?= e((string) $f['t1']) ?></h1>
                <?php foreach (rich_paragraphs((string) ($f['r1'] ?? '')) as $p): ?><p class="pravni__lead"><?= $p ?></p><?php endforeach; ?>
              </header>
            <?php elseif (str_starts_with($key, 'oddil-')): ?>
              <section class="pravni__section">
                <?php if (trim((string) ($f['t1'] ?? '')) !== ''): ?><h2 class="serif pravni__heading"><?= e((string) $f['t1']) ?></h2><?php endif; ?>
                <?php foreach (rich_paragraphs((string) ($f['r1'] ?? '')) as $p): ?><p class="pravni__text"><?= $p ?></p><?php endforeach; ?>
              </section>
            <?php elseif (str_starts_with($key, 'ucel-')): ?>
              <?php if (!$rowsOpen): $rowsOpen = true; ?>
                <table class="pravni__table">
                  <thead><tr><th scope="col">Účel</th><th scope="col">Údaje</th><th scope="col">Právní základ</th><th scope="col">Jak dlouho</th></tr></thead>
                  <tbody>
              <?php endif; ?>
              <tr>
                <th scope="row"><?= e((string) $f['t1']) ?></th>
                <td data-label="Údaje"><?= e((string) $f['t2']) ?></td>
                <td data-label="Právní základ"><?= e((string) $f['t3']) ?></td>
                <td data-label="Jak dlouho"><?= e((string) $f['t4']) ?></td>
              </tr>
            <?php elseif ($key === 'cookies'): ?>
              <table class="pravni__table">
                <thead><tr><th scope="col">Název</th><th scope="col">K čemu slouží</th><th scope="col">Kdo ji ukládá</th><th scope="col">Platnost</th></tr></thead>
                <?php foreach ($cookieCats as $cat => $catLabel): $rows = array_filter(tracking_cookie_rows(), fn($r) => $r[0] === $cat); ?>
                  <tbody>
                    <tr class="pravni__group"><th colspan="4" scope="rowgroup"><?= e($catLabel) ?><?= $cat === 'necessary' ? ' (bez souhlasu)' : ' (jen se souhlasem)' ?></th></tr>
                    <?php if (!$rows): ?>
                      <tr><td colspan="4" class="pravni__empty">Tuto kategorii nyní nepoužíváme.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($rows as [, $name, $purpose, $who, $dur]): ?>
                      <tr><th scope="row"><?= e($name) ?></th><td data-label="K čemu slouží"><?= e($purpose) ?></td><td data-label="Kdo"><?= e($who) ?></td><td data-label="Platnost"><?= e($dur) ?></td></tr>
                    <?php endforeach; ?>
                  </tbody>
                <?php endforeach; ?>
              </table>
            <?php elseif ($key === 'tlacitko'): ?>
              <p class="pravni__section"><button class="btn-primary pravni__btn" type="button" data-on-click="openCookies"><?= e((string) $f['t1']) ?></button></p>
            <?php endif; ?>
          <?php endforeach; $closeRows(); ?>
        </article>
      </div>
    </section>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
