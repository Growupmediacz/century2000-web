<?php $files = $page['options']['files'] ?? []; ?>
<div class="page">
  <?php partial('header'); ?>
  <main>
    <section class="reference-hero" aria-labelledby="hero-h1">
      <div class="reference-hero__overlay" aria-hidden="true"></div>
      <div class="reference-hero__overlay-2" aria-hidden="true"></div>
      <div class="container reference-hero__inner">
        <nav aria-label="Drobečková navigace">
          <ol class="text-muted clanek-hero__crumbs">
            <li><a href="/">Úvod</a></li><li aria-hidden="true">/</li>
            <li><a href="/latky-a-metraz/">Látky a metráž</a></li><li aria-hidden="true">/</li>
            <li aria-current="page">Vzorkovníky</li>
          </ol>
        </nav>
        <span class="rule reference-hero__rule" aria-hidden="true"></span>
        <h1 class="title-hero reference-hero__title" id="hero-h1"><?= t('uvodni-blok.t1') ?></h1>
        <p class="text reference-hero__text"><?= t('uvodni-blok.t2') ?></p>
      </div>
    </section>
    <section aria-labelledby="h-ke-stazeni">
      <div class="container section-pad vzorkovniky">
        <h2 class="title-section" id="h-ke-stazeni"><?= t('ke-stazeni.t1') ?></h2>
        <p class="text-muted vzorkovniky__warning"><?= t('ke-stazeni.t2') ?></p>
        <ul class="vzorkovniky__list">
          <?php foreach ($files as $f): ?>
          <li class="vzorkovniky__item">
            <a class="vzorkovniky__link" href="<?= e($f['file']) ?>" download>
              <span class="serif vzorkovniky__title"><?= e($f['title']) ?></span>
              <span class="text-muted">PDF · <?= e($f['size']) ?></span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
    <?php if (visible('vzorkovnice-na-miru')): ?>
    <section class="vzorkovniky-partner" aria-labelledby="h-partner">
      <div class="container section-pad vzorkovniky-partner__inner">
        <h2 class="title-section" id="h-partner"><?= t('vzorkovnice-na-miru.t1') ?></h2>
        <p class="text"><?= t('vzorkovnice-na-miru.t2') ?></p>
        <ul class="clanek-body__list"><?php foreach (text_lines((string) (content_field('vzorkovnice-na-miru.t3')['value'] ?? '')) as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul>
        <p class="text"><?= rich('vzorkovnice-na-miru.r1') ?></p>
      </div>
    </section>
    <?php endif; ?>
    <section class="reference-zaverecne-cta" aria-labelledby="h-cta">
      <div class="container reference-zaverecne-cta__inner">
        <span class="rule reference-zaverecne-cta__rule" aria-hidden="true"></span>
        <h2 class="serif reference-zaverecne-cta__heading" id="h-cta">Hledáte konkrétní látku?</h2>
        <p class="text reference-zaverecne-cta__text">Napište nám a pošleme vám fyzický vzorkovník nebo poradíme s výběrem.</p>
        <div class="reference-zaverecne-cta__row">
          <a class="btn-primary reference-zaverecne-cta__btn" href="/kontakt/#poptavka">Odeslat poptávku</a>
        </div>
      </div>
    </section>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
