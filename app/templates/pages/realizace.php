<?php
$gallery = [];
foreach ($page['sections'] as $s) {
    if ($s['key'] === 'galerie' && !empty($s['visible'])) {
        foreach ($s['fields'] as $f) {
            if ($f['type'] === 'image' && !empty($f['value']['src'])) {
                $gallery[] = $f['value'];
            }
        }
    }
}
$done = text_lines(str_replace(', ', "\n", (string) (page_field($page, 'popis', 't1')['value'] ?? '')));
?>
<div class="page">
  <?php partial('header'); ?>
  <main>
    <article>
      <header class="clanek-hero">
        <div class="container clanek-hero__inner">
          <nav aria-label="Drobečková navigace">
            <ol class="text-muted clanek-hero__crumbs">
              <li><a href="/">Úvod</a></li><li aria-hidden="true">/</li>
              <li><a href="/reference/">Reference</a></li><li aria-hidden="true">/</li>
              <li aria-current="page"><?= e($page['name']) ?></li>
            </ol>
          </nav>
          <span class="rule clanek-hero__rule" aria-hidden="true"></span>
          <h1 class="title-hero clanek-hero__title"><?= t('hlavicka.t1') ?></h1>
          <?php if (t('hlavicka.t2') !== ''): ?><p class="text-muted clanek-hero__date"><?= t('hlavicka.t2') ?></p><?php endif; ?>
        </div>
        <div class="container clanek-hero__media"><img class="img-cover clanek-hero__img" src="<?= img('hlavicka.img1') ?>" alt="<?= alt('hlavicka.img1') ?>" decoding="async"></div>
      </header>
      <div class="container clanek-body">
        <?php if (t('popis.t2') !== ''): ?><p class="text clanek-body__p"><?= t('popis.t2') ?></p><?php endif; ?>
        <?php if ($done): ?>
        <h2 class="title-card clanek-body__h2">Co jsme šili</h2>
        <ul class="clanek-body__list"><?php foreach ($done as $d): ?><li><?= e($d) ?></li><?php endforeach; ?></ul>
        <?php endif; ?>
        <?php if (t('popis.t3') !== ''): ?><p class="text-muted clanek-body__note"><?= t('popis.t3') ?></p><?php endif; ?>
      </div>
      <?php if ($gallery): ?>
      <div class="container section-pad realizace-galerie">
        <h2 class="title-section">Fotogalerie</h2>
        <ul class="realizace-galerie__grid">
          <?php foreach ($gallery as $g): ?>
          <li><a href="<?= e($g['src']) ?>" target="_blank" rel="noopener"><img class="img-cover" src="<?= e(img_small($g['src'])) ?>" alt="<?= e($g['alt'] ?? '') ?>" decoding="async" loading="lazy"></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </article>
    <section class="reference-zaverecne-cta" aria-labelledby="h-cta">
      <div class="container reference-zaverecne-cta__inner">
        <span class="rule reference-zaverecne-cta__rule" aria-hidden="true"></span>
        <h2 class="serif reference-zaverecne-cta__heading" id="h-cta">Chcete podobné vybavení?</h2>
        <p class="text reference-zaverecne-cta__text">Napište nám, co potřebujete ušít. Ozveme se s dotazy nebo orientační nabídkou.</p>
        <div class="reference-zaverecne-cta__row">
          <a class="btn-primary reference-zaverecne-cta__btn" href="/kontakt/#poptavka">Odeslat poptávku</a>
          <a class="link-arrow" href="/reference/">← Všechny reference</a>
        </div>
      </div>
    </section>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
