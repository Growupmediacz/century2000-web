<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="bytovy-textil-na-miru-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="show-desktop">
        <div class="bytovy-textil-na-miru-hero__grid">
          <div class="bytovy-textil-na-miru-hero__stack">
            <nav aria-label="Drobečková navigace">
              <ol class="text-muted bytovy-textil-na-miru-hero__meta">
                <li class="bytovy-textil-na-miru-hero__item-2"><a class="bytovy-textil-na-miru-hero__link--desktop" href="/#co-sijeme"><?= t('uvodni-blok.t1') ?></a><span aria-hidden="true"><?= t('uvodni-blok.t2') ?></span></li>
                <li class="bytovy-textil-na-miru-hero__item" aria-current="page"><?= t('uvodni-blok.t3') ?></li>
              </ol>
            </nav>
            <h1 class="title-hero bytovy-textil-na-miru-hero__title--desktop" id="hero-h1"><?= t('uvodni-blok.t4') ?></h1>
            <p class="text bytovy-textil-na-miru-hero__text--desktop"><?= t('uvodni-blok.t5') ?></p>
            <div class="bytovy-textil-na-miru-hero__row--desktop">
              <a class="btn-primary bytovy-textil-na-miru-hero__btn-2" href="#poptavka"><?= t('uvodni-blok.t6') ?></a>
              <a class="btn-secondary bytovy-textil-na-miru-hero__btn--desktop" href="#jak-zmerit"><?= t('uvodni-blok.t7') ?></a>
            </div>
          </div>
          <div class="bytovy-textil-na-miru-hero__box">
            <img class="img-cover bytovy-textil-na-miru-hero__img" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
          </div>
        </div>
      </div>
      <div class="show-mobile">
        <img class="bytovy-textil-na-miru-hero__img--mobile" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
        <div class="bytovy-textil-na-miru-hero__stack--mobile">
          <nav aria-label="Drobečková navigace">
            <ol class="text-muted bytovy-textil-na-miru-hero__meta">
              <li class="bytovy-textil-na-miru-hero__item-2"><a class="bytovy-textil-na-miru-hero__link" href="/#co-sijeme"><?= t('uvodni-blok.t1') ?></a><span aria-hidden="true"><?= t('uvodni-blok.t2') ?></span></li>
              <li class="bytovy-textil-na-miru-hero__item" aria-current="page"><?= t('uvodni-blok.t3') ?></li>
            </ol>
          </nav>
          <h1 class="serif bytovy-textil-na-miru-hero__title" id="hero-h1"><?= t('uvodni-blok.t4') ?></h1>
          <p class="text bytovy-textil-na-miru-hero__text"><?= t('uvodni-blok.t5') ?></p>
          <div class="bytovy-textil-na-miru-hero__row">
            <a class="btn-primary bytovy-textil-na-miru-hero__btn--mobile" href="#poptavka"><?= t('uvodni-blok.t6') ?></a>
            <a class="btn-secondary bytovy-textil-na-miru-hero__btn" href="#jak-zmerit"><?= t('uvodni-blok.t7') ?></a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('pro-koho')): ?>
    <section class="bytovy-textil-na-miru-pro-koho" data-screen-label="Pro koho" aria-labelledby="h-prokoho">
      <div class="container section-pad bytovy-textil-na-miru-pro-koho__inner">
        <div class="bytovy-textil-na-miru-pro-koho__stack-2">
          <span class="rule bytovy-textil-na-miru-pro-koho__rule" aria-hidden="true"></span>
          <h2 class="title-section" id="h-prokoho"><?= t('pro-koho.t1') ?></h2>
        </div>
        <div class="bytovy-textil-na-miru-pro-koho__grid">
          <div class="bytovy-textil-na-miru-pro-koho__stack">
            <h3 class="title-card"><?= t('pro-koho.t2') ?></h3>
            <p class="text"><?= t('pro-koho.t3') ?></p>
          </div>
          <div class="bytovy-textil-na-miru-pro-koho__stack">
            <h3 class="title-card"><?= t('pro-koho.t4') ?></h3>
            <p class="text"><?= t('pro-koho.t5') ?></p>
          </div>
          <div class="bytovy-textil-na-miru-pro-koho__stack">
            <h3 class="title-card"><?= t('pro-koho.t6') ?></h3>
            <p class="text"><?= t('pro-koho.t7') ?></p>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('co-sijeme')): ?>
    <section data-screen-label="Co šijeme" aria-labelledby="h-cosijeme">
      <div class="container section-pad co-sijeme__inner">
        <div class="co-sijeme__stack-2">
          <span class="eyebrow co-sijeme__eyebrow"><?= t('co-sijeme.t1') ?></span>
          <span class="rule co-sijeme__rule" aria-hidden="true"></span>
          <h2 class="title-section" id="h-cosijeme"><?= t('co-sijeme.t2') ?></h2>
        </div>
        <ul class="co-sijeme__list">
            <li class="co-sijeme__item">
                <div class="co-sijeme__media-2"><img class="img-cover" src="<?= img('co-sijeme.img1') ?>" alt="<?= alt('co-sijeme.img1') ?>" decoding="async" loading="lazy"></div>
              <div class="co-sijeme__stack">
                <h3 class="title-card"><?= t('co-sijeme.t3') ?></h3>
                <p class="text co-sijeme__text"><?= t('co-sijeme.t4') ?></p>
              </div>
            </li>
            <li class="co-sijeme__item">
                <div class="co-sijeme__media-2"><img class="img-cover" src="<?= img('co-sijeme.img2') ?>" alt="<?= alt('co-sijeme.img2') ?>" decoding="async" loading="lazy"></div>
              <div class="co-sijeme__stack">
                <h3 class="title-card"><?= t('co-sijeme.t5') ?></h3>
                <p class="text co-sijeme__text"><?= t('co-sijeme.t6') ?></p>
              </div>
            </li>
            <li class="co-sijeme__item">
                <div class="co-sijeme__media-2"><img class="img-cover" src="<?= img('co-sijeme.img3') ?>" alt="<?= alt('co-sijeme.img3') ?>" decoding="async" loading="lazy"></div>
              <div class="co-sijeme__stack">
                <h3 class="title-card"><?= t('co-sijeme.t7') ?></h3>
                <p class="text co-sijeme__text"><?= t('co-sijeme.t8') ?></p>
              </div>
            </li>
            <li class="co-sijeme__item">
                <div class="co-sijeme__media-2"><img class="img-cover" src="<?= img('co-sijeme.img4') ?>" alt="<?= alt('co-sijeme.img4') ?>" decoding="async" loading="lazy"></div>
              <div class="co-sijeme__stack">
                <h3 class="title-card"><?= t('co-sijeme.t9') ?></h3>
                <p class="text co-sijeme__text"><?= t('co-sijeme.t10') ?></p>
              </div>
            </li>
            <li class="co-sijeme__item">
                <div class="co-sijeme__media-2"><img class="img-cover" src="<?= img('co-sijeme.img5') ?>" alt="<?= alt('co-sijeme.img5') ?>" decoding="async" loading="lazy"></div>
              <div class="co-sijeme__stack">
                <h3 class="title-card"><?= t('co-sijeme.t11') ?></h3>
                <p class="text co-sijeme__text"><?= t('co-sijeme.t12') ?></p>
              </div>
            </li>
            <li class="co-sijeme__item">
                <div class="co-sijeme__media-2"><img class="img-cover" src="<?= img('co-sijeme.img6') ?>" alt="<?= alt('co-sijeme.img6') ?>" decoding="async" loading="lazy"></div>
              <div class="co-sijeme__stack">
                <h3 class="title-card"><?= t('co-sijeme.t14') ?></h3>
                <p class="text co-sijeme__text"><?= t('co-sijeme.t15') ?></p>
              </div>
            </li>
        </ul>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('materialy')): ?>
    <section class="materialy" data-screen-label="Materiály" aria-labelledby="h-materialy">
      <div class="container section-pad materialy__inner">
        <div class="materialy__stack">
          <span class="eyebrow materialy__eyebrow"><?= t('materialy.t1') ?></span>
          <span class="rule materialy__rule" aria-hidden="true"></span>
          <h2 class="serif materialy__heading" id="h-materialy"><?= t('materialy.t2') ?></h2>
          <p class="text materialy__text"><?= t('materialy.t3') ?></p>
        </div>
        <a class="btn-primary materialy__btn" href="#poptavka"><?= t('materialy.t4') ?></a>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('jak-zmerit-okno')): ?>
    <section class="jak-zmerit-okno" id="jak-zmerit" data-screen-label="Jak změřit okno" aria-labelledby="h-zmerit">
      <div class="container section-pad jak-zmerit-okno__inner">
        <div class="jak-zmerit-okno__box">
          <img class="img-cover jak-zmerit-okno__img" src="<?= img('jak-zmerit-okno.img1') ?>" alt="<?= alt('jak-zmerit-okno.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="jak-zmerit-okno__stack-2">
          <div class="jak-zmerit-okno__stack">
            <span class="rule jak-zmerit-okno__rule" aria-hidden="true"></span>
            <h2 class="title-section" id="h-zmerit"><?= t('jak-zmerit-okno.t1') ?></h2>
          </div>
          <ol class="jak-zmerit-okno__list">
              <li class="jak-zmerit-okno__item">
                <span class="serif jak-zmerit-okno__label"><?= t('jak-zmerit-okno.t2') ?></span>
                <p class="text"><?= t('jak-zmerit-okno.t3') ?></p>
              </li>
              <li class="jak-zmerit-okno__item">
                <span class="serif jak-zmerit-okno__label"><?= t('jak-zmerit-okno.t4') ?></span>
                <p class="text"><?= t('jak-zmerit-okno.t5') ?></p>
              </li>
              <li class="jak-zmerit-okno__item">
                <span class="serif jak-zmerit-okno__label"><?= t('jak-zmerit-okno.t6') ?></span>
                <p class="text"><?= t('jak-zmerit-okno.t7') ?></p>
              </li>
              <li class="jak-zmerit-okno__item">
                <span class="serif jak-zmerit-okno__label"><?= t('jak-zmerit-okno.t8') ?></span>
                <p class="text"><?= rich('jak-zmerit-okno.r1') ?></p>
              </li>
          </ol>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('jak-zakazka-probiha')): ?>
    <section class="bytovy-textil-na-miru-jak-zakazka-probiha" data-screen-label="Jak zakázka probíhá" aria-labelledby="h-postup">
      <div class="container section-pad bytovy-textil-na-miru-jak-zakazka-probiha__inner">
        <div class="bytovy-textil-na-miru-jak-zakazka-probiha__stack">
          <span class="rule bytovy-textil-na-miru-jak-zakazka-probiha__rule" aria-hidden="true"></span>
          <h2 class="title-section" id="h-postup"><?= t('jak-zakazka-probiha.t1') ?></h2>
        </div>
        <ol class="bytovy-textil-na-miru-jak-zakazka-probiha__list">
            <li class="bytovy-textil-na-miru-jak-zakazka-probiha__item">
              <div class="bytovy-textil-na-miru-jak-zakazka-probiha__row"><span class="serif bytovy-textil-na-miru-jak-zakazka-probiha__label-2"><?= t('jak-zakazka-probiha.t2') ?></span><span class="bytovy-textil-na-miru-jak-zakazka-probiha__label" aria-hidden="true"></span></div>
              <h3 class="serif bytovy-textil-na-miru-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t3') ?></h3>
              <p class="text"><?= t('jak-zakazka-probiha.t4') ?></p>
            </li>
            <li class="bytovy-textil-na-miru-jak-zakazka-probiha__item">
              <div class="bytovy-textil-na-miru-jak-zakazka-probiha__row"><span class="serif bytovy-textil-na-miru-jak-zakazka-probiha__label-2"><?= t('jak-zakazka-probiha.t5') ?></span><span class="bytovy-textil-na-miru-jak-zakazka-probiha__label" aria-hidden="true"></span></div>
              <h3 class="serif bytovy-textil-na-miru-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t6') ?></h3>
              <p class="text"><?= t('jak-zakazka-probiha.t7') ?></p>
            </li>
            <li class="bytovy-textil-na-miru-jak-zakazka-probiha__item">
              <div class="bytovy-textil-na-miru-jak-zakazka-probiha__row"><span class="serif bytovy-textil-na-miru-jak-zakazka-probiha__label-2"><?= t('jak-zakazka-probiha.t8') ?></span><span class="bytovy-textil-na-miru-jak-zakazka-probiha__label" aria-hidden="true"></span></div>
              <h3 class="serif bytovy-textil-na-miru-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t9') ?></h3>
              <p class="text"><?= rich('jak-zakazka-probiha.r1') ?></p>
            </li>
            <li class="bytovy-textil-na-miru-jak-zakazka-probiha__item">
              <div class="bytovy-textil-na-miru-jak-zakazka-probiha__row"><span class="serif bytovy-textil-na-miru-jak-zakazka-probiha__label-2"><?= t('jak-zakazka-probiha.t10') ?></span><span class="bytovy-textil-na-miru-jak-zakazka-probiha__label" aria-hidden="true"></span></div>
              <h3 class="serif bytovy-textil-na-miru-jak-zakazka-probiha__subheading"><?= t('jak-zakazka-probiha.t11') ?></h3>
              <p class="text"><?= rich('jak-zakazka-probiha.r2') ?></p>
            </li>
        </ol>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('caste-dotazy')): ?>
    <section data-screen-label="FAQ" aria-labelledby="h-faq">
      <div class="container section-pad bytovy-textil-na-miru-faq__inner">
        <div class="bytovy-textil-na-miru-faq__stack">
          <span class="rule bytovy-textil-na-miru-faq__rule" aria-hidden="true"></span>
          <h2 class="title-section" id="h-faq"><?= t('caste-dotazy.t1') ?></h2>
        </div>
        <div class="bytovy-textil-na-miru-faq__box-2">
            <div class="bytovy-textil-na-miru-faq__box">
              <h3 class="bytovy-textil-na-miru-faq__subheading">
                <button class="serif bytovy-textil-na-miru-faq__btn" type="button" data-on-click="f.toggle" data-idx="0" aria-expanded="true">
                  <?= rich('caste-dotazy.r1') ?>
                  <span class="bytovy-textil-na-miru-faq__label" aria-hidden="true"><?= t('caste-dotazy.t2') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="0">
                <div class="bytovy-textil-na-miru-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t3') ?></p>
                </div>
              </div>
            </div>
            <div class="bytovy-textil-na-miru-faq__box">
              <h3 class="bytovy-textil-na-miru-faq__subheading">
                <button class="serif bytovy-textil-na-miru-faq__btn" type="button" data-on-click="f.toggle" data-idx="1" aria-expanded="false">
                  <?= rich('caste-dotazy.r2') ?>
                  <span class="bytovy-textil-na-miru-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="1" hidden>
                <div class="bytovy-textil-na-miru-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t5') ?></p>
                </div>
              </div>
            </div>
            <div class="bytovy-textil-na-miru-faq__box">
              <h3 class="bytovy-textil-na-miru-faq__subheading">
                <button class="serif bytovy-textil-na-miru-faq__btn" type="button" data-on-click="f.toggle" data-idx="2" aria-expanded="false">
                  <?= rich('caste-dotazy.r3') ?>
                  <span class="bytovy-textil-na-miru-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="2" hidden>
                <div class="bytovy-textil-na-miru-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t6') ?></p>
                </div>
              </div>
            </div>
            <div class="bytovy-textil-na-miru-faq__box">
              <h3 class="bytovy-textil-na-miru-faq__subheading">
                <button class="serif bytovy-textil-na-miru-faq__btn" type="button" data-on-click="f.toggle" data-idx="3" aria-expanded="false">
                  <?= rich('caste-dotazy.r4') ?>
                  <span class="bytovy-textil-na-miru-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="3" hidden>
                <div class="bytovy-textil-na-miru-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t8') ?></p>
                </div>
              </div>
            </div>
            <div class="bytovy-textil-na-miru-faq__box">
              <h3 class="bytovy-textil-na-miru-faq__subheading">
                <button class="serif bytovy-textil-na-miru-faq__btn" type="button" data-on-click="f.toggle" data-idx="4" aria-expanded="false">
                  <?= rich('caste-dotazy.r5') ?>
                  <span class="bytovy-textil-na-miru-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="4" hidden>
                <div class="bytovy-textil-na-miru-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t7') ?></p>
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('poptavka')): ?>
    <section class="bytovy-textil-na-miru-poptavka" data-screen-label="Poptávka">
      <div class="container section-pad">
        <div class="inquiry" data-c="PoptavkovyFormular" data-p-heading="Pošlete nám rozměry a fotku okna" data-p-service="Bytový textil" id="poptavka">
  <form class="inquiry__form" data-on-submit="submit" data-thanks="/dekujeme/" novalidate action="/odeslat/poptavka/" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?= form_token() ?>">
    <div class="form-hp" aria-hidden="true"><label>Nevyplňujte <input type="text" name="web" tabindex="-1" autocomplete="off"></label></div>
    <p class="form-alert" id="formular-chyba" role="alert" hidden></p>
    <div class="inquiry__intro">
      <h2 class="title-section"><?= t('poptavka.t1') ?></h2>
        <p class="text inquiry__lead"><?= rich('poptavka.r1') ?></p>
    </div>
    <label class="inquiry__field">
      <span class="inquiry__field-label">O jakou službu jde?</span>
      <span class="inquiry__select-wrap">
        <select class="field inquiry__select" name="service">
          <option value="">—</option>
          <option selected>Bytový textil</option>
          <option>Hotelový textil</option>
          <option>Strojní prošívání</option>
          <option>Matracové chrániče a potahy</option>
          <option>Látky a metráž</option>
          <option>Jiné</option>
        </select>
        <span class="inquiry__select-arrow" aria-hidden="true"></span>
      </span>
    </label>
    <div class="inquiry__row">
      <label class="inquiry__field--half">
        <span class="inquiry__field-label">Jméno a příjmení*</span>
        <input class="field inquiry__input" type="text" autocomplete="name" aria-invalid="false" name="name">
        <span data-if="e.name" hidden><span class="inquiry__error">Vyplňte prosím toto pole.</span></span>
      </label>
      <label class="inquiry__field--half">
        <span class="inquiry__field-label">E-mail*</span>
        <input class="field inquiry__input" type="email" autocomplete="email" aria-invalid="false" name="email">
        <span data-if="e.emailEmpty" hidden><span class="inquiry__error">Vyplňte prosím toto pole.</span></span>
        <span data-if="e.emailInvalid" hidden><span class="inquiry__error">Zadejte platný e-mail.</span></span>
      </label>
    </div>
    <div class="inquiry__row">
      <label class="inquiry__field--half">
        <span class="inquiry__field-label">Telefon</span>
        <input class="field inquiry__input" type="tel" autocomplete="tel" name="phone">
      </label>
      <label class="inquiry__field--half">
        <span class="inquiry__field-label">Firma (nepovinné)</span>
        <input class="field inquiry__input" type="text" autocomplete="organization" name="company">
      </label>
    </div>
    <label class="inquiry__field">
      <span class="inquiry__field-label">Co potřebujete?*</span>
      <textarea class="field inquiry__textarea" rows="5" placeholder="Např. 4 závěsy do obýváku, okno 240 × 260 cm, látka ideálně len…" aria-invalid="false" name="message"></textarea>
      <span data-if="e.message" hidden><span class="inquiry__error">Vyplňte prosím toto pole.</span></span>
    </label>
    <div class="inquiry__file">
      <span class="inquiry__field-label"><?= t('poptavka.t2') ?></span>
      <label class="inquiry__file-drop">
        <input class="inquiry__file-input" type="file" data-on-change="onFile" name="attachment">
        <span class="btn-secondary inquiry__file-btn">Vybrat soubor</span>
        <span class="text-muted inquiry__file-name"></span>
      </label>
      <div data-if="e.file" hidden><span class="inquiry__error">Soubor je větší než 10 MB.</span></div>
    </div>
    <p class="text-muted inquiry__consent"><?= rich('poptavka.r2') ?></p>
    <button class="btn-primary inquiry__submit" type="submit">Odeslat poptávku</button>
  </form>
  <aside class="inquiry__aside">
    <span class="serif inquiry__aside-title"><?= t('poptavka.t3') ?></span>
    <a class="serif inquiry__aside-phone" href="tel:+420603287803"><?= t('poptavka.t4') ?></a>
    <a class="inquiry__aside-email" href="mailto:info@century2000.cz"><?= t('poptavka.t5') ?></a>
    <span class="inquiry__aside-hours"><?= t('poptavka.t6') ?></span>
  </aside>
</div>
      </div>
    </section>
    <?php endif; ?>
    <?php partial('clanky-teaser'); ?>
    <?php if (visible('souvisejici-sluzby')): ?>
    <section data-screen-label="Související služby" aria-labelledby="h-souvisejici">
      <div class="container section-pad bytovy-textil-na-miru-souvisejici-sluzby__inner">
        <div class="bytovy-textil-na-miru-souvisejici-sluzby__stack">
          <span class="rule bytovy-textil-na-miru-souvisejici-sluzby__rule" aria-hidden="true"></span>
          <h2 class="title-section" id="h-souvisejici"><?= t('souvisejici-sluzby.t1') ?></h2>
        </div>
        <div class="bytovy-textil-na-miru-souvisejici-sluzby__row">
          <div class="bytovy-textil-na-miru-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/latky-a-metraz/">
  <div class="service-card__media">
    <img class="img-cover service-card__img" src="<?= img('souvisejici-sluzby.img1') ?>" alt="<?= alt('souvisejici-sluzby.img1') ?>" decoding="async" loading="lazy">
  </div>
  <div class="service-card__body">
    <h3 class="title-card"><?= t('souvisejici-sluzby.t2') ?></h3>
    <p class="text service-card__text"><?= t('souvisejici-sluzby.t3') ?></p>
    <span class="link-arrow service-card__cta"><?= t('souvisejici-sluzby.t4') ?></span>
  </div>
  <span class="service-card__deco" aria-hidden="true"></span>
</a></div></div>
          <div class="bytovy-textil-na-miru-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/hotelovy-textil/">
  <div class="service-card__media">
    <img class="img-cover service-card__img" src="<?= img('souvisejici-sluzby.img2') ?>" alt="<?= alt('souvisejici-sluzby.img2') ?>" decoding="async" loading="lazy">
  </div>
  <div class="service-card__body">
    <h3 class="title-card"><?= t('souvisejici-sluzby.t5') ?></h3>
    <p class="text service-card__text"><?= t('souvisejici-sluzby.t6') ?></p>
    <span class="link-arrow service-card__cta"><?= t('souvisejici-sluzby.t7') ?></span>
  </div>
  <span class="service-card__deco" aria-hidden="true"></span>
</a></div></div>
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
