<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('stranka-nenalezena')): ?>
    <section data-screen-label="404" aria-labelledby="hero-h1">
      <div class="container page-404__inner">
        <span class="rule page-404__rule" aria-hidden="true"></span>
        <p class="eyebrow page-404__eyebrow"><?= t('stranka-nenalezena.t1') ?></p>
        <h1 class="title-hero page-404__title" id="hero-h1"><?= t('stranka-nenalezena.t2') ?></h1>
        <p class="text page-404__text"><?= t('stranka-nenalezena.t3') ?></p>
        <div class="show-desktop">
          <ul class="page-404__list--desktop">
              <li class="page-404__item--desktop"><a class="page-404__btn--desktop" href="/bytovy-textil-na-miru/">
                <div class="page-404__media--desktop"><img class="img-cover" src="<?= img('stranka-nenalezena.img1') ?>" alt="<?= alt('stranka-nenalezena.img1') ?>" decoding="async"></div>
                <span class="page-404__label-2">
                  <span class="serif page-404__label--desktop"><?= rich('stranka-nenalezena.r1') ?><span class="page-404__label-3" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span></span>
                  <span class="page-404__label-4"><?= t('stranka-nenalezena.t5') ?></span>
                </span>
              </a></li>
              <li class="page-404__item--desktop"><a class="page-404__btn--desktop" href="/hotelovy-textil/">
                <div class="page-404__media--desktop"><img class="img-cover" src="<?= img('stranka-nenalezena.img2') ?>" alt="<?= alt('stranka-nenalezena.img2') ?>" decoding="async"></div>
                <span class="page-404__label-2">
                  <span class="serif page-404__label--desktop"><?= rich('stranka-nenalezena.r2') ?><span class="page-404__label-3" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span></span>
                  <span class="page-404__label-4"><?= t('stranka-nenalezena.t6') ?></span>
                </span>
              </a></li>
              <li class="page-404__item--desktop"><a class="page-404__btn--desktop" href="/strojni-prosivani/">
                <div class="page-404__media--desktop"><img class="img-cover" src="<?= img('stranka-nenalezena.img3') ?>" alt="<?= alt('stranka-nenalezena.img3') ?>" decoding="async"></div>
                <span class="page-404__label-2">
                  <span class="serif page-404__label--desktop"><?= rich('stranka-nenalezena.r3') ?><span class="page-404__label-3" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span></span>
                  <span class="page-404__label-4"><?= t('stranka-nenalezena.t7') ?></span>
                </span>
              </a></li>
              <li class="page-404__item-2"><a class="page-404__btn--desktop" href="/matracove-chranice-a-potahy/">
                <div class="page-404__media"><img class="img-cover" src="<?= img('stranka-nenalezena.img4') ?>" alt="<?= alt('stranka-nenalezena.img4') ?>" decoding="async"></div>
                <span class="page-404__label-2">
                  <span class="serif page-404__label--desktop"><?= rich('stranka-nenalezena.r4') ?><span class="page-404__label-3" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span></span>
                  <span class="page-404__label-4"><?= t('stranka-nenalezena.t8') ?></span>
                </span>
              </a></li>
              <li class="page-404__item-2"><a class="page-404__btn--desktop" href="/latky-a-metraz/">
                <div class="page-404__media"><img class="img-cover" src="<?= img('stranka-nenalezena.img5') ?>" alt="<?= alt('stranka-nenalezena.img5') ?>" decoding="async"></div>
                <span class="page-404__label-2">
                  <span class="serif page-404__label--desktop"><?= rich('stranka-nenalezena.r5') ?><span class="page-404__label-3" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span></span>
                  <span class="page-404__label-4"><?= t('stranka-nenalezena.t9') ?></span>
                </span>
              </a></li>
          </ul>
        </div>
        <div class="show-mobile">
          <ul class="page-404__list">
              <li class="page-404__item"><a class="page-404__link" href="/bytovy-textil-na-miru/">
                <img class="page-404__img" src="<?= img('stranka-nenalezena.img1') ?>" alt="<?= alt('stranka-nenalezena.img1') ?>" decoding="async">
                <span class="serif page-404__label--mobile"><?= t('stranka-nenalezena.t10') ?></span><span class="page-404__label" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span>
              </a></li>
              <li class="page-404__item"><a class="page-404__link" href="/hotelovy-textil/">
                <img class="page-404__img" src="<?= img('stranka-nenalezena.img2') ?>" alt="<?= alt('stranka-nenalezena.img2') ?>" decoding="async">
                <span class="serif page-404__label--mobile"><?= t('stranka-nenalezena.t11') ?></span><span class="page-404__label" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span>
              </a></li>
              <li class="page-404__item"><a class="page-404__link" href="/strojni-prosivani/">
                <img class="page-404__img" src="<?= img('stranka-nenalezena.img3') ?>" alt="<?= alt('stranka-nenalezena.img3') ?>" decoding="async">
                <span class="serif page-404__label--mobile"><?= t('stranka-nenalezena.t12') ?></span><span class="page-404__label" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span>
              </a></li>
              <li class="page-404__item"><a class="page-404__link" href="/matracove-chranice-a-potahy/">
                <img class="page-404__img" src="<?= img('stranka-nenalezena.img4') ?>" alt="<?= alt('stranka-nenalezena.img4') ?>" decoding="async">
                <span class="serif page-404__label--mobile"><?= t('stranka-nenalezena.t13') ?></span><span class="page-404__label" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span>
              </a></li>
              <li class="page-404__item"><a class="page-404__link" href="/latky-a-metraz/">
                <img class="page-404__img" src="<?= img('stranka-nenalezena.img5') ?>" alt="<?= alt('stranka-nenalezena.img5') ?>" decoding="async">
                <span class="serif page-404__label--mobile"><?= t('stranka-nenalezena.t14') ?></span><span class="page-404__label" aria-hidden="true"><?= t('stranka-nenalezena.t4') ?></span>
              </a></li>
          </ul>
        </div>
        <div class="page-404__row">
          <a class="btn-primary page-404__btn-2" href="/"><?= t('stranka-nenalezena.t15') ?></a>
          <a class="btn-secondary page-404__btn" href="/kontakt/"><?= t('stranka-nenalezena.t16') ?></a>
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
