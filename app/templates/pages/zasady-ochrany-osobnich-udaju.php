<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('zasady-ochrany-osobnich-udaju')): ?>
    <section data-screen-label="Zásady ochrany osobních údajů" aria-labelledby="hero-h1">
      <div class="container zasady-ochrany-osobnich-udaju__inner">
        <article class="zasady-ochrany-osobnich-udaju__box">
        <div class="zasady-ochrany-osobnich-udaju__stack-2">
          <span class="rule zasady-ochrany-osobnich-udaju__rule" aria-hidden="true"></span>
          <h1 class="title-hero zasady-ochrany-osobnich-udaju__title" id="hero-h1"><?= t('zasady-ochrany-osobnich-udaju.t1') ?></h1>
          <p class="text zasady-ochrany-osobnich-udaju__text-2"><?= rich('zasady-ochrany-osobnich-udaju.r1') ?></p>
        </div>
        <section class="zasady-ochrany-osobnich-udaju__stack-4">
          <h2 class="serif zasady-ochrany-osobnich-udaju__heading"><?= t('zasady-ochrany-osobnich-udaju.t2') ?></h2>
          <p class="text zasady-ochrany-osobnich-udaju__text"><?= rich('zasady-ochrany-osobnich-udaju.r2') ?></p>
        </section>
        <section class="zasady-ochrany-osobnich-udaju__stack-4">
          <h2 class="serif zasady-ochrany-osobnich-udaju__heading"><?= t('zasady-ochrany-osobnich-udaju.t3') ?></h2>
          <div class="show-desktop">
            <table class="zasady-ochrany-osobnich-udaju__table">
              <thead><tr><th class="zasady-ochrany-osobnich-udaju__th" scope="col"><?= t('zasady-ochrany-osobnich-udaju.t4') ?></th><th class="zasady-ochrany-osobnich-udaju__th" scope="col"><?= t('zasady-ochrany-osobnich-udaju.t5') ?></th><th class="zasady-ochrany-osobnich-udaju__th" scope="col"><?= t('zasady-ochrany-osobnich-udaju.t6') ?></th><th class="zasady-ochrany-osobnich-udaju__th" scope="col"><?= t('zasady-ochrany-osobnich-udaju.t7') ?></th></tr></thead>
              <tbody>
                <tr><th class="zasady-ochrany-osobnich-udaju__th--desktop" scope="row"><?= t('zasady-ochrany-osobnich-udaju.t8') ?></th><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t9') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t10') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><mark class="todo zasady-ochrany-osobnich-udaju__note"><?= t('zasady-ochrany-osobnich-udaju.t11') ?></mark></td></tr>
                <tr><th class="zasady-ochrany-osobnich-udaju__th--desktop" scope="row"><?= t('zasady-ochrany-osobnich-udaju.t12') ?></th><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t13') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t14') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t15') ?></td></tr>
                <tr><th class="zasady-ochrany-osobnich-udaju__th--desktop" scope="row"><?= t('zasady-ochrany-osobnich-udaju.t16') ?></th><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t17') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t18') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><mark class="todo zasady-ochrany-osobnich-udaju__note"><?= t('zasady-ochrany-osobnich-udaju.t19') ?></mark></td></tr>
                <tr><th class="zasady-ochrany-osobnich-udaju__th--desktop" scope="row"><?= t('zasady-ochrany-osobnich-udaju.t20') ?></th><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t21') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><?= t('zasady-ochrany-osobnich-udaju.t22') ?></td><td class="zasady-ochrany-osobnich-udaju__cell"><?= rich('zasady-ochrany-osobnich-udaju.r3') ?></td></tr>
              </tbody>
            </table>
          </div>
          <div class="show-mobile">
            <div class="zasady-ochrany-osobnich-udaju__stack">
              <div class="zasady-ochrany-osobnich-udaju__stack--mobile">
                <h3 class="serif zasady-ochrany-osobnich-udaju__subheading"><?= t('zasady-ochrany-osobnich-udaju.t8') ?></h3>
                <dl class="zasady-ochrany-osobnich-udaju__facts"><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t5') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t9') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t6') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t10') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t7') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><mark class="todo zasady-ochrany-osobnich-udaju__note"><?= t('zasady-ochrany-osobnich-udaju.t11') ?></mark></dd></div></dl>
              </div>
              <div class="zasady-ochrany-osobnich-udaju__stack--mobile">
                <h3 class="serif zasady-ochrany-osobnich-udaju__subheading"><?= t('zasady-ochrany-osobnich-udaju.t12') ?></h3>
                <dl class="zasady-ochrany-osobnich-udaju__facts"><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t5') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t13') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t6') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t14') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t7') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t15') ?></dd></div></dl>
              </div>
              <div class="zasady-ochrany-osobnich-udaju__stack--mobile">
                <h3 class="serif zasady-ochrany-osobnich-udaju__subheading"><?= t('zasady-ochrany-osobnich-udaju.t16') ?></h3>
                <dl class="zasady-ochrany-osobnich-udaju__facts"><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t5') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t17') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t6') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t18') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t7') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><mark class="todo zasady-ochrany-osobnich-udaju__note"><?= t('zasady-ochrany-osobnich-udaju.t19') ?></mark></dd></div></dl>
              </div>
              <div class="zasady-ochrany-osobnich-udaju__stack--mobile">
                <h3 class="serif zasady-ochrany-osobnich-udaju__subheading"><?= t('zasady-ochrany-osobnich-udaju.t20') ?></h3>
                <dl class="zasady-ochrany-osobnich-udaju__facts"><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t5') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t21') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t6') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= t('zasady-ochrany-osobnich-udaju.t22') ?></dd></div><div class="zasady-ochrany-osobnich-udaju__stack-3"><dt class="zasady-ochrany-osobnich-udaju__term"><?= t('zasady-ochrany-osobnich-udaju.t7') ?></dt><dd class="zasady-ochrany-osobnich-udaju__value"><?= rich('zasady-ochrany-osobnich-udaju.r3') ?></dd></div></dl>
              </div>
            </div>
          </div>
        </section>
        <section class="zasady-ochrany-osobnich-udaju__stack-4">
          <h2 class="serif zasady-ochrany-osobnich-udaju__heading"><?= t('zasady-ochrany-osobnich-udaju.t23') ?></h2>
          <p class="text zasady-ochrany-osobnich-udaju__text"><?= rich('zasady-ochrany-osobnich-udaju.r4') ?></p>
        </section>
        <section class="zasady-ochrany-osobnich-udaju__stack-4">
          <h2 class="serif zasady-ochrany-osobnich-udaju__heading"><?= t('zasady-ochrany-osobnich-udaju.t24') ?></h2>
          <p class="text zasady-ochrany-osobnich-udaju__text"><?= rich('zasady-ochrany-osobnich-udaju.r5') ?></p>
          <p class="text zasady-ochrany-osobnich-udaju__text"><?= rich('zasady-ochrany-osobnich-udaju.r6') ?></p>
        </section>
        <section class="zasady-ochrany-osobnich-udaju__stack-4">
          <h2 class="serif zasady-ochrany-osobnich-udaju__heading"><?= t('zasady-ochrany-osobnich-udaju.t25') ?></h2>
          <p class="text zasady-ochrany-osobnich-udaju__text"><?= rich('zasady-ochrany-osobnich-udaju.r7') ?></p>
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
