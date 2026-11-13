<?php $articles = pages_of_type('article'); ?>
<div class="page">
  <?php partial('header'); ?>
  <main>
    <section class="reference-hero" aria-labelledby="hero-h1">
      <div class="reference-hero__overlay" aria-hidden="true"></div>
      <div class="reference-hero__overlay-2" aria-hidden="true"></div>
      <div class="container reference-hero__inner">
        <span class="rule reference-hero__rule" aria-hidden="true"></span>
        <h1 class="title-hero reference-hero__title" id="hero-h1"><?= t('uvodni-blok.t1') ?></h1>
        <p class="text reference-hero__text"><?= t('uvodni-blok.t2') ?></p>
      </div>
    </section>
    <section aria-label="Seznam článků">
      <div class="container section-pad">
        <ul class="clanky-grid">
          <?php foreach ($articles as $p): $im = page_field($p, 'hlavicka', 'img1'); $perex = page_field($p, 'hlavicka', 't2'); ?>
          <li class="clanky-card"><a class="clanky-card__link" href="<?= e($p['path']) ?>">
            <?php if ($im): ?><span class="clanky-card__media"><img class="img-cover" src="<?= e(img_small($im['value']['src'])) ?>" alt="<?= e($im['value']['alt'] ?? '') ?>" decoding="async" loading="lazy"></span><?php endif; ?>
            <span class="clanky-card__body">
              <span class="text-muted"><?= e(cs_date($p['options']['date'] ?? '')) ?></span>
              <span class="serif clanky-card__title"><?= e($p['name']) ?></span>
              <span class="text clanky-card__perex"><?= e((string) ($perex['value'] ?? '')) ?></span>
              <span class="link-arrow">Číst článek →</span>
            </span>
          </a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
    <?php if (visible('vyzva-na-konci-stranky')): ?>
    <section class="reference-zaverecne-cta" aria-labelledby="h-cta">
      <div class="container reference-zaverecne-cta__inner">
        <span class="rule reference-zaverecne-cta__rule" aria-hidden="true"></span>
        <h2 class="serif reference-zaverecne-cta__heading" id="h-cta"><?= t('vyzva-na-konci-stranky.t1') ?></h2>
        <p class="text reference-zaverecne-cta__text"><?= t('vyzva-na-konci-stranky.t2') ?></p>
        <div class="reference-zaverecne-cta__row">
          <a class="btn-primary reference-zaverecne-cta__btn" href="/kontakt/#poptavka"><?= t('vyzva-na-konci-stranky.t3') ?></a>
        </div>
      </div>
    </section>
    <?php endif; ?>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
