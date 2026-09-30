<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('dekujeme-kariera')): ?>
    <section class="dekujeme-kariera" data-screen-label="Děkujeme (kariéra)" aria-labelledby="hero-h1">
      <div class="container dekujeme-kariera__inner">
        <div class="dekujeme-kariera__stack">
          <span class="rule dekujeme-kariera__rule" aria-hidden="true"></span>
          <h1 class="serif dekujeme-kariera__title" id="hero-h1"><?= t('dekujeme-kariera.t1') ?></h1>
          <p class="text dekujeme-kariera__text"><?= t('dekujeme-kariera.t2') ?></p>
        </div>
        <div class="show-desktop">
          <div class="dekujeme-kariera__box"><img class="img-cover" src="<?= img('dekujeme-kariera.img1') ?>" alt="<?= alt('dekujeme-kariera.img1') ?>" decoding="async"></div>
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
