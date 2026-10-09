<?php
$o = $page['options'];
$blocks = body_blocks($page);
$others = array_filter(pages_of_type('article'), fn($p) => $p['path'] !== $page['path']);
$others = array_slice($others, 0, 3);
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
              <li><a href="/clanky/">Články</a></li><li aria-hidden="true">/</li>
              <li aria-current="page"><?= e($page['name']) ?></li>
            </ol>
          </nav>
          <span class="rule clanek-hero__rule" aria-hidden="true"></span>
          <h1 class="title-hero clanek-hero__title"><?= t('hlavicka.t1') ?></h1>
          <p class="text clanek-hero__perex"><?= t('hlavicka.t2') ?></p>
          <p class="text-muted clanek-hero__date"><time datetime="<?= e($o['date'] ?? '') ?>"><?= e(cs_date($o['date'] ?? '')) ?></time> · Century 2000</p>
        </div>
        <?php if (img('hlavicka.img1') !== ''): ?>
        <div class="container clanek-hero__media"><img class="img-cover clanek-hero__img" src="<?= img('hlavicka.img1') ?>" alt="<?= alt('hlavicka.img1') ?>" decoding="async"></div>
        <?php endif; ?>
      </header>
      <div class="container clanek-body">
        <?php foreach ($blocks as $b): ?>
        <section class="clanek-body__block" id="<?= e($b['id']) ?>">
          <?php if ($b['h'] !== ''): ?><h2 class="title-card clanek-body__h2"><?= e($b['h']) ?></h2><?php endif; ?>
          <?php foreach ($b['paragraphs'] as $p): ?><p class="text clanek-body__p"><?= $p ?></p><?php endforeach; ?>
          <?php if ($b['items']): ?><ul class="clanek-body__list"><?php foreach ($b['items'] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul><?php endif; ?>
        </section>
        <?php endforeach; ?>
      </div>
    </article>
    <?php if (visible('souvisejici-sluzba')): ?>
    <section class="clanek-cta" aria-labelledby="h-clanek-cta">
      <div class="container clanek-cta__inner">
        <div class="clanek-cta__text">
          <span class="eyebrow clanek-cta__eyebrow"><?= t('souvisejici-sluzba.t1') ?></span>
          <h2 class="serif clanek-cta__heading" id="h-clanek-cta"><?= t('souvisejici-sluzba.t2') ?></h2>
          <p class="text"><?= t('souvisejici-sluzba.t3') ?></p>
        </div>
        <div class="clanek-cta__buttons">
          <a class="link-arrow" href="<?= t('souvisejici-sluzba.t4') ?>"><?= t('souvisejici-sluzba.t5') ?></a>
          <a class="btn-primary clanek-cta__btn" href="/kontakt/#poptavka">Nezávazná poptávka</a>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if ($others): ?>
    <section class="clanek-dalsi" aria-labelledby="h-dalsi">
      <div class="container section-pad clanek-dalsi__inner">
        <h2 class="title-section" id="h-dalsi">Další články</h2>
        <ul class="clanky-grid">
          <?php foreach ($others as $p): $im = page_field($p, 'hlavicka', 'img1'); ?>
          <li class="clanky-card"><a class="clanky-card__link" href="<?= e($p['path']) ?>">
            <?php if ($im): ?><span class="clanky-card__media"><img class="img-cover" src="<?= e(img_small($im['value']['src'])) ?>" alt="" decoding="async" loading="lazy"></span><?php endif; ?>
            <span class="clanky-card__body"><span class="serif clanky-card__title"><?= e($p['name']) ?></span></span>
          </a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
    <?php endif; ?>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
