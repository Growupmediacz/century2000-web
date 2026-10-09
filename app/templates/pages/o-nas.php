<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="o-nas-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="show-desktop">
        <div class="o-nas-hero__grid">
          <div class="o-nas-hero__stack--desktop">
            <div class="o-nas-hero__stack"><span class="eyebrow o-nas-hero__eyebrow"><?= t('uvodni-blok.t1') ?></span><span class="rule o-nas-hero__rule" aria-hidden="true"></span></div>
            <h1 class="title-hero o-nas-hero__title--desktop" id="hero-h1"><?= t('uvodni-blok.t2') ?></h1>
            <p class="text o-nas-hero__text--desktop"><?= rich('uvodni-blok.r1') ?></p>
          </div>
          <div class="o-nas-hero__box">
            <img class="img-cover o-nas-hero__img" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
          </div>
        </div>
      </div>
      <div class="show-mobile">
        <img class="o-nas-hero__img--mobile" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
        <div class="o-nas-hero__stack--mobile">
          <span class="eyebrow o-nas-hero__eyebrow"><?= t('uvodni-blok.t1') ?></span>
          <h1 class="serif o-nas-hero__title" id="hero-h1"><?= t('uvodni-blok.t2') ?></h1>
          <p class="text o-nas-hero__text"><?= rich('uvodni-blok.r1') ?></p>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('nas-pribeh')): ?>
    <section data-screen-label="Náš příběh" aria-labelledby="h-pribeh">
      <div class="container section-pad nas-pribeh__inner">
        <div class="nas-pribeh__box"><div class="nas-pribeh__stack">
          <span class="eyebrow nas-pribeh__eyebrow"><?= t('nas-pribeh.t1') ?></span>
          <span class="rule nas-pribeh__rule" aria-hidden="true"></span>
          <h2 class="title-section nas-pribeh__heading" id="h-pribeh"><?= t('nas-pribeh.t2') ?></h2>
        </div></div>
        <div class="nas-pribeh__stack-2">
          <p class="text"><?= t('nas-pribeh.t3') ?></p>
          <p class="text"><?= t('nas-pribeh.t4') ?></p>
          <?php if (t('nas-pribeh.t5') !== ''): ?><p class="nas-pribeh__text"><?= t('nas-pribeh.t5') ?></p><?php endif; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('dilna-v-cislech')): ?>
    <section class="o-nas-dilna-v-cislech" data-screen-label="Dílna v číslech">
      <div class="container section-pad o-nas-dilna-v-cislech__inner">
        <div class="o-nas-dilna-v-cislech__box">
          <img class="img-cover o-nas-dilna-v-cislech__img" src="<?= img('dilna-v-cislech.img1') ?>" alt="<?= alt('dilna-v-cislech.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="o-nas-dilna-v-cislech__stack-3">
          <div class="o-nas-dilna-v-cislech__stack"><p class="eyebrow o-nas-dilna-v-cislech__eyebrow"><?= t('dilna-v-cislech.t1') ?></p><span class="rule o-nas-dilna-v-cislech__rule" aria-hidden="true"></span></div>
          <dl class="o-nas-dilna-v-cislech__facts">
            <div class="o-nas-dilna-v-cislech__stack-2"><dt class="text-muted o-nas-dilna-v-cislech__meta"><?= t('dilna-v-cislech.t2') ?></dt><dd class="serif o-nas-dilna-v-cislech__value"><?= t('dilna-v-cislech.t3') ?></dd></div>
            <div class="o-nas-dilna-v-cislech__stack-2"><dt class="text-muted o-nas-dilna-v-cislech__meta"><?= t('dilna-v-cislech.t4') ?></dt><dd class="serif o-nas-dilna-v-cislech__value"><?= t('dilna-v-cislech.t5') ?></dd></div>
            <div class="o-nas-dilna-v-cislech__stack-2"><dt class="text-muted o-nas-dilna-v-cislech__meta"><?= t('dilna-v-cislech.t6') ?></dt><dd class="serif o-nas-dilna-v-cislech__value"><?= t('dilna-v-cislech.t7') ?></dd></div>
            <div class="o-nas-dilna-v-cislech__stack-2"><dt class="text-muted o-nas-dilna-v-cislech__meta"><?= t('dilna-v-cislech.t8') ?></dt><dd class="serif o-nas-dilna-v-cislech__value"><?= t('dilna-v-cislech.t9') ?></dd></div>
            <div class="o-nas-dilna-v-cislech__stack-2"><dt class="text-muted o-nas-dilna-v-cislech__meta"><?= t('dilna-v-cislech.t10') ?></dt><dd class="serif o-nas-dilna-v-cislech__value"><?= t('dilna-v-cislech.t11') ?></dd></div>
            <?php if (t('dilna-v-cislech.t12') !== ''): ?><div class="o-nas-dilna-v-cislech__row"><?= t('dilna-v-cislech.t12') ?></div><?php endif; ?>
          </dl>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('italske-know-how')): ?>
    <section class="italske-know-how" data-screen-label="Italské know-how" aria-labelledby="h-italie">
      <div class="container section-pad italske-know-how__inner">
        <div class="italske-know-how__stack">
          <span class="eyebrow italske-know-how__eyebrow"><?= t('italske-know-how.t1') ?></span>
          <span class="rule italske-know-how__rule" aria-hidden="true"></span>
          <h2 class="serif italske-know-how__heading" id="h-italie"><?= t('italske-know-how.t2') ?></h2>
          <p class="text italske-know-how__text"><?= rich('italske-know-how.r1') ?></p>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('na-cem-si-zakladame')): ?>
    <section data-screen-label="Na čem si zakládáme" aria-labelledby="h-hodnoty">
      <div class="container section-pad na-cem-si-zakladame__inner">
        <div class="na-cem-si-zakladame__stack-2">
          <span class="rule na-cem-si-zakladame__rule" aria-hidden="true"></span>
          <h2 class="title-section na-cem-si-zakladame__heading" id="h-hodnoty"><?= t('na-cem-si-zakladame.t1') ?></h2>
        </div>
        <div class="na-cem-si-zakladame__grid">
            <div class="na-cem-si-zakladame__stack">
              <h3 class="title-card"><?= t('na-cem-si-zakladame.t2') ?></h3>
              <p class="text"><?= t('na-cem-si-zakladame.t3') ?></p>
            </div>
            <div class="na-cem-si-zakladame__stack">
              <h3 class="title-card"><?= t('na-cem-si-zakladame.t4') ?></h3>
              <p class="text"><?= t('na-cem-si-zakladame.t5') ?></p>
            </div>
            <div class="na-cem-si-zakladame__stack">
              <h3 class="title-card"><?= t('na-cem-si-zakladame.t6') ?></h3>
              <p class="text"><?= t('na-cem-si-zakladame.t7') ?></p>
            </div>
            <div class="na-cem-si-zakladame__stack">
              <h3 class="title-card"><?= t('na-cem-si-zakladame.t8') ?></h3>
              <p class="text"><?= t('na-cem-si-zakladame.t9') ?></p>
            </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('lide')): ?>
    <section class="lide" data-screen-label="Lidé" aria-labelledby="h-lide">
      <div class="container section-pad lide__inner">
        <div class="lide__media">
          <div class="text-muted lide__meta"><?= t('lide.t1') ?></div>
        </div>
        <div class="lide__stack-3">
          <div class="lide__stack"><span class="eyebrow lide__eyebrow"><?= t('lide.t2') ?></span><span class="rule lide__rule" aria-hidden="true"></span></div>
          <div class="lide__stack-2">
            <h2 class="title-section lide__heading" id="h-lide"><?= t('lide.t3') ?></h2>
            <p class="lide__text"><?= t('lide.t4') ?></p>
          </div>
          <?php if (t('lide.t5') !== ''): ?><blockquote class="lide__quote"><?= t('lide.t5') ?></blockquote><?php endif; ?>
          <div class="lide__row">
            <a class="link-arrow lide__link" href="tel:+420603287803"><?= t('lide.t6') ?></a>
            <a class="link-arrow lide__link" href="mailto:vobecky@century2000.cz"><?= t('lide.t7') ?></a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('vyzva-na-konci-stranky')): ?>
    <section data-screen-label="Závěrečné CTA" aria-labelledby="h-cta">
      <div class="container section-pad o-nas-zaverecne-cta__inner">
        <div class="o-nas-zaverecne-cta__box">
          <img class="img-cover o-nas-zaverecne-cta__img" src="<?= img('vyzva-na-konci-stranky.img1') ?>" alt="<?= alt('vyzva-na-konci-stranky.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="o-nas-zaverecne-cta__stack-2">
          <div class="o-nas-zaverecne-cta__stack">
          <span class="rule o-nas-zaverecne-cta__rule" aria-hidden="true"></span>
          <h2 class="title-section o-nas-zaverecne-cta__heading" id="h-cta"><?= t('vyzva-na-konci-stranky.t1') ?></h2>
        </div>
          <p class="text o-nas-zaverecne-cta__text"><?= t('vyzva-na-konci-stranky.t2') ?></p>
          <div class="o-nas-zaverecne-cta__row">
            <a class="btn-primary o-nas-zaverecne-cta__btn-2" href="/kontakt/"><?= t('vyzva-na-konci-stranky.t3') ?></a>
            <a class="btn-secondary o-nas-zaverecne-cta__btn" href="/kariera/"><?= t('vyzva-na-konci-stranky.t4') ?></a>
          </div>
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
