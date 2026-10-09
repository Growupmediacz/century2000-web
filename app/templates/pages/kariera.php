<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="kariera-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="show-desktop">
        <div class="kariera-hero__grid">
          <div class="kariera-hero__stack--desktop">
            <div class="kariera-hero__stack"><span class="eyebrow kariera-hero__eyebrow"><?= t('uvodni-blok.t1') ?></span><span class="rule kariera-hero__rule" aria-hidden="true"></span></div>
            <h1 class="title-hero kariera-hero__title--desktop" id="hero-h1"><?= t('uvodni-blok.t2') ?></h1>
            <p class="text kariera-hero__text--desktop"><?= t('uvodni-blok.t3') ?></p>
            <div class="kariera-hero__row--desktop">
              <a class="btn-primary kariera-hero__btn-2" href="#pozice"><?= t('uvodni-blok.t4') ?></a>
              <a class="btn-secondary kariera-hero__btn--desktop" href="#formular"><?= t('uvodni-blok.t5') ?></a>
            </div>
          </div>
          <div class="kariera-hero__box">
            <img class="img-cover kariera-hero__img" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
          </div>
        </div>
      </div>
      <div class="show-mobile">
        <img class="kariera-hero__img--mobile" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
        <div class="kariera-hero__stack--mobile">
          <span class="eyebrow kariera-hero__eyebrow"><?= t('uvodni-blok.t1') ?></span>
          <h1 class="serif kariera-hero__title" id="hero-h1"><?= t('uvodni-blok.t2') ?></h1>
          <p class="text kariera-hero__text"><?= t('uvodni-blok.t3') ?></p>
          <div class="kariera-hero__row">
            <a class="btn-primary kariera-hero__btn--mobile" href="#pozice"><?= t('uvodni-blok.t4') ?></a>
            <a class="btn-secondary kariera-hero__btn" href="#formular"><?= t('uvodni-blok.t5') ?></a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('proc-pracovat-u-nas')): ?>
    <section data-screen-label="Proč pracovat u nás" aria-labelledby="h-proc">
      <div class="container section-pad proc-pracovat-u-nas__inner">
        <div class="proc-pracovat-u-nas__box">
          <img class="img-cover proc-pracovat-u-nas__img" src="<?= img('proc-pracovat-u-nas.img1') ?>" alt="<?= alt('proc-pracovat-u-nas.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="proc-pracovat-u-nas__stack-3">
          <div class="proc-pracovat-u-nas__stack-2">
          <span class="rule proc-pracovat-u-nas__rule" aria-hidden="true"></span>
          <h2 class="title-section proc-pracovat-u-nas__heading" id="h-proc"><?= t('proc-pracovat-u-nas.t1') ?></h2>
        </div>
          <div class="proc-pracovat-u-nas__grid">
            <div class="proc-pracovat-u-nas__stack">
              <h3 class="title-card"><?= t('proc-pracovat-u-nas.t2') ?></h3>
              <p class="text"><?= t('proc-pracovat-u-nas.t3') ?></p>
            </div>
            <div class="proc-pracovat-u-nas__stack">
              <h3 class="title-card"><?= t('proc-pracovat-u-nas.t4') ?></h3>
              <p class="text"><?= t('proc-pracovat-u-nas.t5') ?></p>
            </div>
            <div class="proc-pracovat-u-nas__stack">
              <h3 class="title-card"><?= t('proc-pracovat-u-nas.t6') ?></h3>
              <p class="text"><?= t('proc-pracovat-u-nas.t7') ?></p>
            </div>
            <div class="proc-pracovat-u-nas__stack">
              <h3 class="title-card"><?= t('proc-pracovat-u-nas.t8') ?></h3>
              <p class="text"><?= t('proc-pracovat-u-nas.t9') ?></p>
            </div>
            <div class="proc-pracovat-u-nas__stack">
              <h3 class="title-card"><?= t('proc-pracovat-u-nas.t10') ?></h3>
              <p class="text"><?= t('proc-pracovat-u-nas.t11') ?></p>
            </div>
            <div class="proc-pracovat-u-nas__stack">
              <?php if (t('proc-pracovat-u-nas.t12') !== ''): ?><p class="proc-pracovat-u-nas__text"><?= t('proc-pracovat-u-nas.t12') ?></p><?php endif; ?>
            </div>
        </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('otevrene-pozice')): ?>
    <section class="otevrene-pozice" id="pozice" data-screen-label="Otevřené pozice" aria-labelledby="h-pozice">
      <div class="container section-pad otevrene-pozice__inner">
        <div class="otevrene-pozice__stack-4">
          <span class="rule otevrene-pozice__rule" aria-hidden="true"></span>
          <h2 class="title-section otevrene-pozice__heading" id="h-pozice"><?= t('otevrene-pozice.t1') ?></h2>
        </div>
        <article class="otevrene-pozice__stack">
          <div class="otevrene-pozice__row-3">
            <div class="otevrene-pozice__stack-3">
              <h3 class="serif otevrene-pozice__subheading"><?= t('otevrene-pozice.t2') ?></h3>
              <?php if (t('otevrene-pozice.t3') !== ''): ?><p class="otevrene-pozice__text-2"><?= t('otevrene-pozice.t3') ?></p><?php endif; ?>
              <p class="otevrene-pozice__text-3"><?= rich('otevrene-pozice.r1') ?></p>
            </div>
            <a class="btn-primary otevrene-pozice__btn-2" href="#formular" data-on-click="applyMain"><?= t('otevrene-pozice.t4') ?></a>
          </div>
          <div class="otevrene-pozice__grid">
              <div class="otevrene-pozice__stack-3">
                <h4 class="eyebrow otevrene-pozice__eyebrow"><?= t('otevrene-pozice.t5') ?></h4>
                <ul class="otevrene-pozice__list"><li class="otevrene-pozice__item"><span class="otevrene-pozice__label" aria-hidden="true"></span><?= rich('otevrene-pozice.r2') ?></li><li class="otevrene-pozice__item"><span class="otevrene-pozice__label" aria-hidden="true"></span><?= rich('otevrene-pozice.r3') ?></li><li class="otevrene-pozice__item"><span class="otevrene-pozice__label" aria-hidden="true"></span><?= rich('otevrene-pozice.r4') ?></li></ul>
              </div>
              <div class="otevrene-pozice__stack-3">
                <h4 class="eyebrow otevrene-pozice__eyebrow"><?= t('otevrene-pozice.t6') ?></h4>
                <ul class="otevrene-pozice__list"><li class="otevrene-pozice__item"><span class="otevrene-pozice__label" aria-hidden="true"></span><?= rich('otevrene-pozice.r5') ?></li><li class="otevrene-pozice__item"><span class="otevrene-pozice__label" aria-hidden="true"></span><?= rich('otevrene-pozice.r6') ?></li><li class="otevrene-pozice__item"><span class="otevrene-pozice__label" aria-hidden="true"></span><?= rich('otevrene-pozice.r7') ?></li></ul>
              </div>
              <div class="otevrene-pozice__stack-3">
                <h4 class="eyebrow otevrene-pozice__eyebrow"><?= t('otevrene-pozice.t7') ?></h4>
                <ul class="otevrene-pozice__list"><li class="otevrene-pozice__item"><span class="otevrene-pozice__label" aria-hidden="true"></span><?= rich('otevrene-pozice.r8') ?></li></ul>
              </div>
          </div>
        </article>
        <article class="otevrene-pozice__row">
          <div class="otevrene-pozice__stack-2">
            <h3 class="title-card"><?= t('otevrene-pozice.t8') ?></h3>
            <?php if (t('otevrene-pozice.t9') !== ''): ?><p class="otevrene-pozice__text-2"><?= t('otevrene-pozice.t9') ?></p><?php endif; ?>
          </div>
          <a class="btn-secondary otevrene-pozice__btn" href="#formular" data-on-click="applyMachine"><?= t('otevrene-pozice.t4') ?></a>
        </article>
        <div class="otevrene-pozice__row-2">
          <h3 class="title-card"><?= t('otevrene-pozice.t10') ?></h3>
          <p class="text otevrene-pozice__text"><?= t('otevrene-pozice.t11') ?></p>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('formular-pro-uchazece')): ?>
    <section class="formular-pro-uchazece" id="formular" data-screen-label="Formulář pro uchazeče" aria-labelledby="h-formular">
      <div class="container section-pad formular-pro-uchazece__inner">
        <form class="formular-pro-uchazece__form" data-on-submit="fSubmit" data-thanks="/dekujeme-kariera/" novalidate action="/odeslat/kariera/" method="post" enctype="multipart/form-data">
          <input type="hidden" name="token" value="<?= form_token() ?>">
          <div class="form-hp" aria-hidden="true"><label>Nevyplňujte <input type="text" name="web" tabindex="-1" autocomplete="off"></label></div>
          <p class="form-alert" id="formular-chyba" role="alert" hidden></p>
          <h2 class="title-section formular-pro-uchazece__heading" id="h-formular"><?= t('formular-pro-uchazece.t1') ?></h2>
          <div class="formular-pro-uchazece__row">
            <label class="formular-pro-uchazece__field-2">
              <span class="formular-pro-uchazece__label-3">Jméno a příjmení*</span>
              <input class="field formular-pro-uchazece__input" type="text" autocomplete="name" aria-invalid="false" name="name">
              <span data-if="fe.name" hidden><span class="formular-pro-uchazece__label-2">Vyplňte prosím toto pole.</span></span>
            </label>
            <label class="formular-pro-uchazece__field-2">
              <span class="formular-pro-uchazece__label-3">Telefon*</span>
              <input class="field formular-pro-uchazece__input" type="tel" autocomplete="tel" aria-invalid="false" name="phone">
              <span data-if="fe.phone" hidden><span class="formular-pro-uchazece__label-2">Vyplňte prosím toto pole.</span></span>
            </label>
          </div>
          <div class="formular-pro-uchazece__row">
            <label class="formular-pro-uchazece__field-2">
              <span class="formular-pro-uchazece__label-3">E-mail</span>
              <input class="field formular-pro-uchazece__input" type="email" autocomplete="email" aria-invalid="false" name="email">
              <span data-if="fe.email" hidden><span class="formular-pro-uchazece__label-2">Zadejte platný e-mail.</span></span>
            </label>
            <label class="formular-pro-uchazece__field-2">
              <span class="formular-pro-uchazece__label-3">O jakou pozici máte zájem?</span>
              <input class="field formular-pro-uchazece__input" type="text" name="position">
            </label>
          </div>
          <label class="formular-pro-uchazece__field">
            <span class="formular-pro-uchazece__label-3">Krátce o vašich zkušenostech</span>
            <textarea class="field formular-pro-uchazece__input-3" rows="5" name="about"></textarea>
          </label>
          <div class="formular-pro-uchazece__stack">
            <span class="formular-pro-uchazece__label-3"><?= t('formular-pro-uchazece.t2') ?></span>
            <label class="formular-pro-uchazece__field-3">
              <input class="formular-pro-uchazece__input-2" type="file" accept=".pdf,.doc,.docx,image/*" data-on-change="fFile" name="attachment">
              <span class="btn-secondary formular-pro-uchazece__btn-2">Vybrat soubor</span>
              <span class="text-muted formular-pro-uchazece__meta-2"></span>
            </label>
          </div>
          <p class="text-muted formular-pro-uchazece__meta"><?= rich('formular-pro-uchazece.r1') ?></p>
          <button class="btn-primary formular-pro-uchazece__btn" type="submit">Odeslat</button>
        </form>
        <aside class="formular-pro-uchazece__aside">
          <span class="serif formular-pro-uchazece__label-4"><?= t('formular-pro-uchazece.t3') ?></span>
          <p class="formular-pro-uchazece__text"><?= t('formular-pro-uchazece.t4') ?></p>
          <a class="serif formular-pro-uchazece__link-2" href="tel:+420603287803"><?= t('formular-pro-uchazece.t5') ?></a>
          <span class="formular-pro-uchazece__label"><?= t('formular-pro-uchazece.t6') ?></span>
        </aside>
      </div>
    </section>
    <?php endif; ?>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
