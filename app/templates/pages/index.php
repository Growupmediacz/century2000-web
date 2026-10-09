<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="index-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="show-desktop">
        <img class="img-cover index-hero__img" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
        <div class="index-hero__overlay" aria-hidden="true"></div>
      </div>
      <div class="show-mobile">
        <img class="index-hero__img--mobile" src="<?= img('uvodni-blok.img2') ?>" alt="<?= alt('uvodni-blok.img2') ?>" decoding="async">
      </div>
      <div class="container index-hero__inner">
        <div class="index-hero__stack">
          <p class="index-hero__text-2">
            <span class="eyebrow index-hero__eyebrow"><?= t('uvodni-blok.t1') ?></span>
            <span class="index-hero__label"><?= t('uvodni-blok.t2') ?></span>
          </p>
          <h1 class="title-hero index-hero__title" id="hero-h1"><?= t('uvodni-blok.t3') ?></h1>
          <p class="text index-hero__text"><?= t('uvodni-blok.t4') ?></p>
          <div class="index-hero__row">
            <a class="btn-primary index-hero__btn-2" href="/kontakt/#poptavka"><?= t('uvodni-blok.t5') ?></a>
            <a class="btn-secondary index-hero__btn" href="#co-sijeme"><?= t('uvodni-blok.t6') ?></a>
          </div>
          <ul class="index-hero__list">
            <li class="index-hero__item"><span class="index-hero__deco" aria-hidden="true"></span><?= t('uvodni-blok.t7') ?></li>
            <li class="index-hero__item"><span class="index-hero__deco" aria-hidden="true"></span><?= t('uvodni-blok.t8') ?></li>
            <li class="index-hero__item"><span class="index-hero__deco" aria-hidden="true"></span><?= t('uvodni-blok.t9') ?></li>
          </ul>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('pruh-duvery')): ?>
    <section class="pruh-duvery" data-screen-label="Pruh důvěry" aria-label="Reference hotelů">
      <div class="container pruh-duvery__inner">
        <p class="serif pruh-duvery__text"><?= t('pruh-duvery.t1') ?></p>
        <ul class="pruh-duvery__list">
          <?php foreach (array_filter(pages_of_type('reference'), fn($r) => !empty($r['options']['featured'])) as $r): ?>
          <li class="pruh-duvery__item"><a class="serif pruh-duvery__name" href="<?= e($r['path']) ?>"><?= e(preg_replace('/^Hotel /', '', $r['name'])) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <a class="link-arrow pruh-duvery__link" href="/reference/"><?= t('pruh-duvery.t2') ?></a>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('rozcestnik-sluzeb')): ?>
    <section class="rozcestnik-sluzeb" id="co-sijeme" data-screen-label="Rozcestník služeb" aria-labelledby="h-sluzby">
      <div class="container section-pad rozcestnik-sluzeb__inner">
        <div class="rozcestnik-sluzeb__stack">
          <span class="eyebrow rozcestnik-sluzeb__eyebrow"><?= t('rozcestnik-sluzeb.t1') ?></span>
          <span class="rule rozcestnik-sluzeb__rule" aria-hidden="true"></span>
          <h2 class="title-section rozcestnik-sluzeb__heading" id="h-sluzby"><?= t('rozcestnik-sluzeb.t2') ?></h2>
        </div>
        <div class="rozcestnik-sluzeb__stack-2">
          <div class="rozcestnik-sluzeb__row">
            <div class="rozcestnik-sluzeb__box-2"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/bytovy-textil-na-miru/">
  <div class="service-card__media">
    <img class="img-cover service-card__img" src="<?= img('rozcestnik-sluzeb.img1') ?>" alt="<?= alt('rozcestnik-sluzeb.img1') ?>" decoding="async" loading="lazy">
  </div>
  <div class="service-card__body">
    <h3 class="title-card"><?= t('rozcestnik-sluzeb.t3') ?></h3>
    <p class="text service-card__text"><?= t('rozcestnik-sluzeb.t4') ?></p>
    <span class="link-arrow service-card__cta"><?= t('rozcestnik-sluzeb.t5') ?></span>
  </div>
  <span class="service-card__deco" aria-hidden="true"></span>
</a></div></div>
            <div class="rozcestnik-sluzeb__box-2"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/hotelovy-textil/">
  <div class="service-card__media">
    <img class="img-cover service-card__img" src="<?= img('rozcestnik-sluzeb.img2') ?>" alt="<?= alt('rozcestnik-sluzeb.img2') ?>" decoding="async" loading="lazy">
  </div>
  <div class="service-card__body">
    <h3 class="title-card"><?= t('rozcestnik-sluzeb.t6') ?></h3>
    <p class="text service-card__text"><?= t('rozcestnik-sluzeb.t7') ?></p>
    <span class="link-arrow service-card__cta"><?= t('rozcestnik-sluzeb.t8') ?></span>
  </div>
  <span class="service-card__deco" aria-hidden="true"></span>
</a></div></div>
          </div>
          <div class="rozcestnik-sluzeb__row">
            <div class="rozcestnik-sluzeb__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/strojni-prosivani/">
  <div class="service-card__media">
    <img class="img-cover service-card__img" src="<?= img('rozcestnik-sluzeb.img3') ?>" alt="<?= alt('rozcestnik-sluzeb.img3') ?>" decoding="async" loading="lazy">
  </div>
  <div class="service-card__body">
    <h3 class="title-card"><?= t('rozcestnik-sluzeb.t9') ?></h3>
    <p class="text service-card__text"><?= t('rozcestnik-sluzeb.t10') ?></p>
    <span class="link-arrow service-card__cta"><?= t('rozcestnik-sluzeb.t11') ?></span>
  </div>
  <span class="service-card__deco" aria-hidden="true"></span>
</a></div></div>
            <div class="rozcestnik-sluzeb__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/matracove-chranice-a-potahy/">
  <div class="service-card__media">
    <img class="img-cover service-card__img" src="<?= img('rozcestnik-sluzeb.img4') ?>" alt="<?= alt('rozcestnik-sluzeb.img4') ?>" decoding="async" loading="lazy">
  </div>
  <div class="service-card__body">
    <h3 class="title-card"><?= t('rozcestnik-sluzeb.t12') ?></h3>
    <p class="text service-card__text"><?= t('rozcestnik-sluzeb.t13') ?></p>
    <span class="link-arrow service-card__cta"><?= t('rozcestnik-sluzeb.t14') ?></span>
  </div>
  <span class="service-card__deco" aria-hidden="true"></span>
</a></div></div>
            <div class="rozcestnik-sluzeb__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/latky-a-metraz/">
  <div class="service-card__media">
    <img class="img-cover service-card__img" src="<?= img('rozcestnik-sluzeb.img5') ?>" alt="<?= alt('rozcestnik-sluzeb.img5') ?>" decoding="async" loading="lazy">
  </div>
  <div class="service-card__body">
    <h3 class="title-card"><?= t('rozcestnik-sluzeb.t15') ?></h3>
    <p class="text service-card__text"><?= t('rozcestnik-sluzeb.t16') ?></p>
    <span class="link-arrow service-card__cta"><?= t('rozcestnik-sluzeb.t17') ?></span>
  </div>
  <span class="service-card__deco" aria-hidden="true"></span>
</a></div></div>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('pro-koho-sijeme')): ?>
    <section data-screen-label="Pro koho šijeme" aria-labelledby="h-prokoho">
      <div class="container section-pad pro-koho-sijeme__inner">
        <div class="pro-koho-sijeme__stack">
          <span class="eyebrow pro-koho-sijeme__eyebrow"><?= t('pro-koho-sijeme.t1') ?></span>
          <span class="rule pro-koho-sijeme__rule" aria-hidden="true"></span>
          <h2 class="title-section" id="h-prokoho"><?= t('pro-koho-sijeme.t2') ?></h2>
        </div>
        <div class="pro-koho-sijeme__grid">
          <a class="pro-koho-sijeme__btn" href="/bytovy-textil-na-miru/">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" stroke="#9C7B4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 7 H43"></path><path d="M9 7 C9 19 13 30 8 42"></path><path d="M14 7 C14 19 18 29 13 42"></path><path d="M39 7 C39 19 35 30 40 42"></path><path d="M34 7 C34 19 30 29 35 42"></path><rect x="19" y="13" width="10" height="22"></rect><path d="M24 13 V35 M19 24 H29"></path></svg>
            <h3 class="serif pro-koho-sijeme__subheading"><?= t('pro-koho-sijeme.t3') ?></h3>
            <p class="text pro-koho-sijeme__text"><?= t('pro-koho-sijeme.t4') ?></p>
            <span class="link-arrow pro-koho-sijeme__link"><?= t('pro-koho-sijeme.t5') ?></span>
          </a>
          <a class="pro-koho-sijeme__btn" href="/hotelovy-textil/">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" stroke="#9C7B4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 39 V12"></path><path d="M6 30 H42 V39"></path><path d="M6 35 H42"></path><rect x="10" y="22" width="12" height="8" rx="3"></rect><path d="M26 30 V26 C26 24 27 23 29 23 H39 C41 23 42 24 42 26 V30"></path><path d="M24 8 L25.2 10.8 L28 11.2 L26 13.2 L26.5 16 L24 14.6 L21.5 16 L22 13.2 L20 11.2 L22.8 10.8 Z"></path></svg>
            <h3 class="serif pro-koho-sijeme__subheading"><?= t('pro-koho-sijeme.t6') ?></h3>
            <p class="text pro-koho-sijeme__text"><?= t('pro-koho-sijeme.t7') ?></p>
            <span class="link-arrow pro-koho-sijeme__link"><?= t('pro-koho-sijeme.t8') ?></span>
          </a>
          <a class="pro-koho-sijeme__btn" href="/strojni-prosivani/">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" stroke="#9C7B4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 28 L18 16 L30 28 L18 40 Z"></path><path d="M12 22 L24 34 M24 22 L12 34"></path><path d="M30 28 L42 16"></path><path d="M30 28 L36 34 L42 28 L36 22"></path><path d="M40 4 L28 20"></path><circle cx="40.5" cy="3.5" r="1.8"></circle></svg>
            <h3 class="serif pro-koho-sijeme__subheading"><?= t('pro-koho-sijeme.t9') ?></h3>
            <p class="text pro-koho-sijeme__text"><?= t('pro-koho-sijeme.t10') ?></p>
            <span class="link-arrow pro-koho-sijeme__link"><?= t('pro-koho-sijeme.t11') ?></span>
          </a>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('dilna-v-cislech')): ?>
    <section class="index-dilna-v-cislech" data-screen-label="Dílna v číslech" aria-label="Naše dílna v číslech">
      <div class="container section-pad index-dilna-v-cislech__inner">
        <div class="index-dilna-v-cislech__stack">
          <p class="eyebrow index-dilna-v-cislech__eyebrow"><?= t('dilna-v-cislech.t1') ?></p>
          <span class="rule index-dilna-v-cislech__rule" aria-hidden="true"></span>
        </div>
        <dl class="index-dilna-v-cislech__facts">
          <div class="index-dilna-v-cislech__stack-2">
            <dt class="index-dilna-v-cislech__term"><?= t('dilna-v-cislech.t2') ?></dt>
            <dd class="serif index-dilna-v-cislech__value"><?= t('dilna-v-cislech.t3') ?></dd>
          </div>
          <div class="index-dilna-v-cislech__stack-2">
            <dt class="index-dilna-v-cislech__term"><?= t('dilna-v-cislech.t4') ?></dt>
            <dd class="serif index-dilna-v-cislech__value"><?= t('dilna-v-cislech.t5') ?></dd>
          </div>
          <div class="index-dilna-v-cislech__stack-2">
            <dt class="index-dilna-v-cislech__term"><?= t('dilna-v-cislech.t6') ?></dt>
            <dd class="serif index-dilna-v-cislech__value"><?= t('dilna-v-cislech.t7') ?></dd>
          </div>
          <div class="index-dilna-v-cislech__stack-2">
            <dt class="index-dilna-v-cislech__term"><?= rich('dilna-v-cislech.r1') ?></dt>
            <dd class="serif index-dilna-v-cislech__value"><?= t('dilna-v-cislech.t8') ?></dd>
          </div>
          <div class="index-dilna-v-cislech__stack-2">
            <dt class="index-dilna-v-cislech__term"><?= t('dilna-v-cislech.t9') ?></dt>
            <dd class="serif index-dilna-v-cislech__value"><?= t('dilna-v-cislech.t10') ?></dd>
          </div>
        </dl>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('jak-zakazka-probiha')): ?>
    <section data-screen-label="Jak zakázka probíhá" aria-labelledby="h-postup">
      <div class="container section-pad index-jak-zakazka-probiha__inner">
        <div class="index-jak-zakazka-probiha__stack">
          <span class="eyebrow index-jak-zakazka-probiha__eyebrow"><?= t('jak-zakazka-probiha.t1') ?></span>
          <span class="rule index-jak-zakazka-probiha__rule" aria-hidden="true"></span>
          <h2 class="title-section" id="h-postup"><?= t('jak-zakazka-probiha.t2') ?></h2>
        </div>
        <ol class="index-jak-zakazka-probiha__list">
          <li class="index-jak-zakazka-probiha__item-2">
            <div class="index-jak-zakazka-probiha__row"><span class="serif index-jak-zakazka-probiha__label-3"><?= t('jak-zakazka-probiha.t3') ?></span><span class="index-jak-zakazka-probiha__label-2" aria-hidden="true"></span></div>
            <h3 class="serif index-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t4') ?></h3>
            <p class="text"><?= t('jak-zakazka-probiha.t5') ?></p>
          </li>
          <li class="index-jak-zakazka-probiha__item-2">
            <div class="index-jak-zakazka-probiha__row"><span class="serif index-jak-zakazka-probiha__label-3"><?= t('jak-zakazka-probiha.t6') ?></span><span class="index-jak-zakazka-probiha__label-2" aria-hidden="true"></span></div>
            <h3 class="serif index-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t7') ?></h3>
            <p class="text"><?= t('jak-zakazka-probiha.t8') ?></p>
          </li>
          <li class="index-jak-zakazka-probiha__item-2">
            <div class="index-jak-zakazka-probiha__row"><span class="serif index-jak-zakazka-probiha__label-3"><?= t('jak-zakazka-probiha.t9') ?></span><span class="index-jak-zakazka-probiha__label-2" aria-hidden="true"></span></div>
            <h3 class="serif index-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t10') ?></h3>
            <p class="text"><?= t('jak-zakazka-probiha.t11') ?></p>
          </li>
          <li class="index-jak-zakazka-probiha__item">
            <div class="index-jak-zakazka-probiha__row"><span class="serif index-jak-zakazka-probiha__label-3"><?= t('jak-zakazka-probiha.t12') ?></span><span class="index-jak-zakazka-probiha__label" aria-hidden="true"></span></div>
            <h3 class="serif index-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t13') ?></h3>
            <p class="text"><?= rich('jak-zakazka-probiha.r1') ?></p>
          </li>
        </ol>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('reference')): ?>
    <section class="index-reference" data-screen-label="Reference" aria-labelledby="h-reference">
      <div class="container section-pad index-reference__inner">
        <div class="index-reference__stack">
          <span class="eyebrow index-reference__eyebrow"><?= t('reference.t1') ?></span>
          <span class="rule index-reference__rule" aria-hidden="true"></span>
          <h2 class="title-section index-reference__heading" id="h-reference"><?= t('reference.t2') ?></h2>
          <p class="text index-reference__text"><?= t('reference.t3') ?></p>
          <a class="btn-secondary index-reference__btn" href="/reference/"><?= t('reference.t4') ?></a>
        </div>
        <ul class="index-reference__list">
          <?php foreach (pages_of_type('reference') as $r): $pl = page_field($r, 'hlavicka', 't2'); ?>
            <li class="index-reference__item">
              <a class="serif index-reference__label" href="<?= e($r['path']) ?>"><?= e($r['name']) ?></a>
              <span class="text-muted"><?= e((string) ($pl['value'] ?? '')) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('proc-century-2000')): ?>
    <section data-screen-label="Proč Century 2000" aria-labelledby="h-proc">
      <div class="container section-pad proc-century-2000__inner">
        <div class="proc-century-2000__box">
          <img class="img-cover proc-century-2000__img" src="<?= img('proc-century-2000.img1') ?>" alt="<?= alt('proc-century-2000.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="proc-century-2000__stack-3">
          <div class="proc-century-2000__stack">
            <span class="eyebrow proc-century-2000__eyebrow"><?= t('proc-century-2000.t1') ?></span>
            <span class="rule proc-century-2000__rule" aria-hidden="true"></span>
            <h2 class="title-section proc-century-2000__heading" id="h-proc"><?= t('proc-century-2000.t2') ?></h2>
          </div>
          <div class="proc-century-2000__grid">
            <div class="proc-century-2000__stack-2">
              <h3 class="serif proc-century-2000__subheading"><?= t('proc-century-2000.t3') ?></h3>
              <p class="text"><?= t('proc-century-2000.t4') ?></p>
            </div>
            <div class="proc-century-2000__stack-2">
              <h3 class="serif proc-century-2000__subheading"><?= t('proc-century-2000.t5') ?></h3>
              <p class="text"><?= t('proc-century-2000.t6') ?></p>
            </div>
            <div class="proc-century-2000__stack-2">
              <h3 class="serif proc-century-2000__subheading"><?= t('proc-century-2000.t7') ?></h3>
              <p class="text"><?= t('proc-century-2000.t8') ?></p>
            </div>
            <div class="proc-century-2000__stack-2">
              <h3 class="serif proc-century-2000__subheading"><?= t('proc-century-2000.t9') ?></h3>
              <p class="text"><?= t('proc-century-2000.t10') ?></p>
            </div>
          </div>
          <blockquote class="proc-century-2000__quote">
            <span class="rule proc-century-2000__rule" aria-hidden="true"></span>
            <p class="serif proc-century-2000__text"><?= t('proc-century-2000.t11') ?></p>
          </blockquote>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('vyzva-na-konci-stranky')): ?>
    <section class="index-zaverecne-cta" data-screen-label="Závěrečné CTA" aria-labelledby="h-cta">
      <div class="container index-zaverecne-cta__inner">
        <span class="rule index-zaverecne-cta__rule" aria-hidden="true"></span>
        <h2 class="serif index-zaverecne-cta__heading" id="h-cta"><?= t('vyzva-na-konci-stranky.t1') ?></h2>
        <p class="text index-zaverecne-cta__text"><?= t('vyzva-na-konci-stranky.t2') ?></p>
        <div class="index-zaverecne-cta__row">
          <a class="btn-primary index-zaverecne-cta__btn" href="/kontakt/#poptavka"><?= t('vyzva-na-konci-stranky.t3') ?></a>
          <span class="index-zaverecne-cta__label"><?= rich('vyzva-na-konci-stranky.r1') ?></span>
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
