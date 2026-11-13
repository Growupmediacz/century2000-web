<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('dekujeme')): ?>
    <section class="dekujeme" data-screen-label="Děkujeme" aria-labelledby="hero-h1">
      <div class="container dekujeme__inner">
        <div class="dekujeme__stack-2">
          <span class="rule dekujeme__rule" aria-hidden="true"></span>
          <h1 class="serif dekujeme__title" id="hero-h1"><?= t('dekujeme.t1') ?></h1>
          <p class="text dekujeme__text"><?= rich('dekujeme.r1') ?></p>
          <div class="dekujeme__stack">
            <p class="eyebrow dekujeme__eyebrow"><?= t('dekujeme.t2') ?></p>
            <ul class="dekujeme__list">
              <li class="dekujeme__item"><a class="serif dekujeme__link-2" href="/reference/"><?= rich('dekujeme.r2') ?><span class="dekujeme__label" aria-hidden="true"><?= t('dekujeme.t3') ?></span></a></li>
              <li class="dekujeme__item"><a class="serif dekujeme__link-2" href="/o-nas/"><?= rich('dekujeme.r3') ?><span class="dekujeme__label" aria-hidden="true"><?= t('dekujeme.t3') ?></span></a></li>
              <li class="dekujeme__item"><a class="serif dekujeme__link-2" href="/"><?= rich('dekujeme.r4') ?><span class="dekujeme__label" aria-hidden="true"><?= t('dekujeme.t3') ?></span></a></li>
            </ul>
          </div>
        </div>
        <div class="show-desktop">
          <div class="dekujeme__box"><img class="img-cover" src="<?= img('dekujeme.img1') ?>" alt="<?= alt('dekujeme.img1') ?>" decoding="async"></div>
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
