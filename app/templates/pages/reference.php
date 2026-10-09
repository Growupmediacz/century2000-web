<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="reference-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="reference-hero__overlay" aria-hidden="true"></div>
      <div class="reference-hero__overlay-2" aria-hidden="true"></div>
      <div class="container reference-hero__inner">
        <span class="rule reference-hero__rule" aria-hidden="true"></span>
        <h1 class="title-hero reference-hero__title" id="hero-h1"><?= t('uvodni-blok.t1') ?></h1>
        <p class="text reference-hero__text"><?= t('uvodni-blok.t2') ?></p>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('hotely-pro-ktere-sijeme')): ?>
    <section data-screen-label="Hotely, pro které šijeme" aria-labelledby="h-hotely">
      <div class="container section-pad hotely-pro-ktere-sijeme__inner">
        <div class="hotely-pro-ktere-sijeme__stack">
          <span class="rule hotely-pro-ktere-sijeme__rule" aria-hidden="true"></span>
          <h2 class="title-section hotely-pro-ktere-sijeme__heading" id="h-hotely"><?= t('hotely-pro-ktere-sijeme.t1') ?></h2>
        </div>
        <ul class="reference-grid">
          <?php foreach (pages_of_type('reference') as $r): $im = page_field($r, 'hlavicka', 'img1'); $pl = page_field($r, 'hlavicka', 't2'); $ds = page_field($r, 'popis', 't1'); ?>
          <li class="reference-card"><a class="reference-card__link" href="<?= e($r['path']) ?>">
            <span class="reference-card__media"><img class="img-cover" src="<?= e(img_small($im['value']['src'])) ?>" alt="<?= e($im['value']['alt'] ?? '') ?>" decoding="async" loading="lazy"></span>
            <span class="reference-card__body">
              <span class="serif reference-card__title"><?= e($r['name']) ?></span>
              <?php if (!empty($pl['value'])): ?><span class="text-muted"><?= e($pl['value']) ?></span><?php endif; ?>
              <?php if (!empty($ds['value'])): ?><span class="text reference-card__text"><?= e(ucfirst((string) $ds['value'])) ?></span><?php endif; ?>
              <span class="link-arrow">Fotogalerie →</span>
            </span>
          </a></li>
          <?php endforeach; ?>
        </ul>
        <?php if (t('hotely-pro-ktere-sijeme.t2') !== ''): ?><p class="text-muted hotely-pro-ktere-sijeme__meta"><?= t('hotely-pro-ktere-sijeme.t2') ?></p><?php endif; ?>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('dalsi-oblasti')): ?>
    <section class="dalsi-oblasti" data-screen-label="Další oblasti" aria-labelledby="h-oblasti">
      <div class="container section-pad dalsi-oblasti__inner">
        <div class="dalsi-oblasti__stack-2">
          <span class="rule dalsi-oblasti__rule" aria-hidden="true"></span>
          <h2 class="title-section dalsi-oblasti__heading" id="h-oblasti"><?= t('dalsi-oblasti.t1') ?></h2>
        </div>
        <div class="dalsi-oblasti__grid">
            <div class="dalsi-oblasti__stack">
              <h3 class="title-card"><?= t('dalsi-oblasti.t2') ?></h3>
              <p class="text"><?= t('dalsi-oblasti.t3') ?></p>
            </div>
            <div class="dalsi-oblasti__stack">
              <h3 class="title-card"><?= t('dalsi-oblasti.t4') ?></h3>
              <p class="text"><?= t('dalsi-oblasti.t5') ?></p>
            </div>
            <div class="dalsi-oblasti__stack">
              <h3 class="title-card"><?= t('dalsi-oblasti.t6') ?></h3>
              <p class="text"><?= t('dalsi-oblasti.t7') ?></p>
            </div>
            <div class="dalsi-oblasti__stack">
              <h3 class="title-card"><?= t('dalsi-oblasti.t8') ?></h3>
              <p class="text"><?= t('dalsi-oblasti.t9') ?></p>
            </div>
        </div>
        <p class="text-muted dalsi-oblasti__meta"><?= t('dalsi-oblasti.t10') ?></p>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('vyzva-na-konci-stranky')): ?>
    <section class="reference-zaverecne-cta" data-screen-label="Závěrečné CTA" aria-labelledby="h-cta">
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
