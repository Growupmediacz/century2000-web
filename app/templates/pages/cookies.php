<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('zasady-cookies')): ?>
    <section data-screen-label="Zásady cookies" aria-labelledby="hero-h1">
      <div class="container zasady-cookies__inner">
        <article class="zasady-cookies__box">
        <div class="zasady-cookies__stack-2">
          <span class="rule zasady-cookies__rule" aria-hidden="true"></span>
          <h1 class="title-hero zasady-cookies__title" id="hero-h1"><?= t('zasady-cookies.t1') ?></h1>
          <p class="text zasady-cookies__text-2"><?= t('zasady-cookies.t2') ?></p>
        </div>
        <section class="zasady-cookies__stack-4">
          <h2 class="serif zasady-cookies__heading"><?= t('zasady-cookies.t3') ?></h2>
          <div class="show-desktop">
            <table class="zasady-cookies__table">
              <thead><tr><th class="zasady-cookies__th" scope="col"><?= t('zasady-cookies.t4') ?></th><th class="zasady-cookies__th" scope="col"><?= t('zasady-cookies.t5') ?></th><th class="zasady-cookies__th" scope="col"><?= t('zasady-cookies.t6') ?></th><th class="zasady-cookies__th" scope="col"><?= t('zasady-cookies.t7') ?></th></tr></thead>
              <tbody>
                <tr><th class="zasady-cookies__th--desktop" scope="row"><?= t('zasady-cookies.t8') ?></th><td class="zasady-cookies__cell"><?= t('zasady-cookies.t9') ?></td><td class="zasady-cookies__cell"><?= rich('zasady-cookies.r1') ?></td><td class="zasady-cookies__cell"><?= t('zasady-cookies.t10') ?></td></tr>
                <tr><th class="zasady-cookies__th--desktop" scope="row"><?= t('zasady-cookies.t11') ?></th><td class="zasady-cookies__cell"><?= t('zasady-cookies.t12') ?></td><td class="zasady-cookies__cell"><?= t('zasady-cookies.t13') ?></td><td class="zasady-cookies__cell"><?= t('zasady-cookies.t14') ?></td></tr>
                <tr><th class="zasady-cookies__th--desktop" scope="row"><?= t('zasady-cookies.t15') ?></th><td class="zasady-cookies__cell"><?= t('zasady-cookies.t16') ?></td><td class="zasady-cookies__cell"><mark class="todo zasady-cookies__note"><?= t('zasady-cookies.t17') ?></mark></td><td class="zasady-cookies__cell"><?= t('zasady-cookies.t14') ?></td></tr>
              </tbody>
            </table>
          </div>
          <div class="show-mobile">
            <div class="zasady-cookies__stack">
              <div class="zasady-cookies__stack--mobile">
                <h3 class="serif zasady-cookies__subheading"><?= t('zasady-cookies.t8') ?></h3>
                <dl class="zasady-cookies__facts"><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t5') ?></dt><dd class="zasady-cookies__value"><?= t('zasady-cookies.t9') ?></dd></div><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t6') ?></dt><dd class="zasady-cookies__value"><?= rich('zasady-cookies.r1') ?></dd></div><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t7') ?></dt><dd class="zasady-cookies__value"><?= t('zasady-cookies.t10') ?></dd></div></dl>
              </div>
              <div class="zasady-cookies__stack--mobile">
                <h3 class="serif zasady-cookies__subheading"><?= t('zasady-cookies.t11') ?></h3>
                <dl class="zasady-cookies__facts"><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t5') ?></dt><dd class="zasady-cookies__value"><?= t('zasady-cookies.t12') ?></dd></div><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t6') ?></dt><dd class="zasady-cookies__value"><?= t('zasady-cookies.t13') ?></dd></div><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t7') ?></dt><dd class="zasady-cookies__value"><?= t('zasady-cookies.t14') ?></dd></div></dl>
              </div>
              <div class="zasady-cookies__stack--mobile">
                <h3 class="serif zasady-cookies__subheading"><?= t('zasady-cookies.t15') ?></h3>
                <dl class="zasady-cookies__facts"><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t5') ?></dt><dd class="zasady-cookies__value"><?= t('zasady-cookies.t16') ?></dd></div><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t6') ?></dt><dd class="zasady-cookies__value"><mark class="todo zasady-cookies__note"><?= t('zasady-cookies.t17') ?></mark></dd></div><div class="zasady-cookies__stack-3"><dt class="zasady-cookies__term"><?= t('zasady-cookies.t7') ?></dt><dd class="zasady-cookies__value"><?= t('zasady-cookies.t14') ?></dd></div></dl>
              </div>
            </div>
          </div>
        </section>
        <section class="zasady-cookies__stack-4">
          <h2 class="serif zasady-cookies__heading"><?= t('zasady-cookies.t18') ?></h2>
          <p class="text zasady-cookies__text"><?= rich('zasady-cookies.r2') ?></p>
          <button class="btn-primary zasady-cookies__btn" type="button" data-on-click="openCookies"><?= t('zasady-cookies.t19') ?></button>
        </section>
        <section class="zasady-cookies__stack-4">
          <h2 class="serif zasady-cookies__heading"><?= t('zasady-cookies.t20') ?></h2>
          <p class="text zasady-cookies__text"><?= rich('zasady-cookies.r3') ?></p>
        </section>
        </article>
      </div>
    </section>
    <?php endif; ?>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
