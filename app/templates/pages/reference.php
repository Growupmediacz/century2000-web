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
        <ul class="hotely-pro-ktere-sijeme__list">
            <li class="hotely-pro-ktere-sijeme__item">
              <div class="hotely-pro-ktere-sijeme__row"><img class="hotely-pro-ktere-sijeme__img" src="<?= img('hotely-pro-ktere-sijeme.img1') ?>" alt="<?= alt('hotely-pro-ktere-sijeme.img1') ?>" decoding="async" loading="lazy"></div>
              <div class="hotely-pro-ktere-sijeme__stack-2">
                <h3 class="serif hotely-pro-ktere-sijeme__subheading"><?= t('hotely-pro-ktere-sijeme.t2') ?></h3>
                <span class="text-muted"><?= t('hotely-pro-ktere-sijeme.t3') ?></span>
              </div>
            </li>
            <li class="hotely-pro-ktere-sijeme__item">
              <div class="hotely-pro-ktere-sijeme__row"><img class="hotely-pro-ktere-sijeme__img" src="<?= img('hotely-pro-ktere-sijeme.img2') ?>" alt="<?= alt('hotely-pro-ktere-sijeme.img2') ?>" decoding="async" loading="lazy"></div>
              <div class="hotely-pro-ktere-sijeme__stack-2">
                <h3 class="serif hotely-pro-ktere-sijeme__subheading"><?= t('hotely-pro-ktere-sijeme.t4') ?></h3>
                <span class="text-muted"><?= t('hotely-pro-ktere-sijeme.t3') ?></span>
              </div>
            </li>
            <li class="hotely-pro-ktere-sijeme__item">
              <div class="hotely-pro-ktere-sijeme__row"><img class="hotely-pro-ktere-sijeme__img" src="<?= img('hotely-pro-ktere-sijeme.img3') ?>" alt="<?= alt('hotely-pro-ktere-sijeme.img3') ?>" decoding="async" loading="lazy"></div>
              <div class="hotely-pro-ktere-sijeme__stack-2">
                <h3 class="serif hotely-pro-ktere-sijeme__subheading"><?= t('hotely-pro-ktere-sijeme.t5') ?></h3>
                <span class="text-muted"><?= t('hotely-pro-ktere-sijeme.t3') ?></span>
              </div>
            </li>
            <li class="hotely-pro-ktere-sijeme__item">
              <div class="hotely-pro-ktere-sijeme__row"><img class="hotely-pro-ktere-sijeme__img" src="<?= img('hotely-pro-ktere-sijeme.img4') ?>" alt="<?= alt('hotely-pro-ktere-sijeme.img4') ?>" decoding="async" loading="lazy"></div>
              <div class="hotely-pro-ktere-sijeme__stack-2">
                <h3 class="serif hotely-pro-ktere-sijeme__subheading"><?= t('hotely-pro-ktere-sijeme.t6') ?></h3>
                <span class="text-muted"><?= t('hotely-pro-ktere-sijeme.t7') ?></span>
              </div>
            </li>
            <li class="hotely-pro-ktere-sijeme__item">
              <div class="hotely-pro-ktere-sijeme__row-2"><mark class="hotely-pro-ktere-sijeme__note"><?= t('hotely-pro-ktere-sijeme.t8') ?></mark></div>
              <div class="hotely-pro-ktere-sijeme__stack-2">
                <h3 class="serif hotely-pro-ktere-sijeme__subheading"><?= t('hotely-pro-ktere-sijeme.t9') ?></h3>
                <span class="text-muted"><?= t('hotely-pro-ktere-sijeme.t3') ?></span>
              </div>
            </li>
            <li class="hotely-pro-ktere-sijeme__item">
              <div class="hotely-pro-ktere-sijeme__row-2"><mark class="hotely-pro-ktere-sijeme__note"><?= t('hotely-pro-ktere-sijeme.t8') ?></mark></div>
              <div class="hotely-pro-ktere-sijeme__stack-2">
                <h3 class="serif hotely-pro-ktere-sijeme__subheading"><?= t('hotely-pro-ktere-sijeme.t10') ?></h3>
                <span class="text-muted"><?= t('hotely-pro-ktere-sijeme.t3') ?></span>
              </div>
            </li>
            <li class="hotely-pro-ktere-sijeme__item">
              <div class="hotely-pro-ktere-sijeme__row-2"><mark class="hotely-pro-ktere-sijeme__note"><?= t('hotely-pro-ktere-sijeme.t8') ?></mark></div>
              <div class="hotely-pro-ktere-sijeme__stack-2">
                <h3 class="serif hotely-pro-ktere-sijeme__subheading"><?= t('hotely-pro-ktere-sijeme.t11') ?></h3>
                <span class="text-muted"><?= t('hotely-pro-ktere-sijeme.t12') ?></span>
              </div>
            </li>
        </ul>
        <p class="text-muted hotely-pro-ktere-sijeme__meta"><mark class="todo hotely-pro-ktere-sijeme__note-2"><?= t('hotely-pro-ktere-sijeme.t13') ?></mark></p>
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
