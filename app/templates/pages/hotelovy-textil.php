<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="service-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="show-desktop">
        <div class="service-hero__grid">
          <div class="service-hero__stack">
            <nav aria-label="Drobečková navigace">
              <ol class="text-muted service-hero__meta">
                <li class="service-hero__item-2"><a class="service-hero__link" href="/#co-sijeme"><?= t('uvodni-blok.t1') ?></a><span aria-hidden="true"><?= t('uvodni-blok.t2') ?></span></li>
                <li class="service-hero__item" aria-current="page"><?= t('uvodni-blok.t3') ?></li>
              </ol>
            </nav>
            <h1 class="title-hero service-hero__title--desktop" id="hero-h1"><?= t('uvodni-blok.t4') ?></h1>
            <p class="text service-hero__text--desktop"><?= t('uvodni-blok.t5') ?></p>
            <div class="service-hero__row--desktop">
              <a class="btn-primary service-hero__btn-2" href="#poptavka"><?= t('uvodni-blok.t6') ?></a>
              <a class="btn-secondary service-hero__btn--desktop" href="tel:+420603287803"><?= t('uvodni-blok.t7') ?></a>
            </div>
          </div>
          <div class="service-hero__box">
            <img class="img-cover service-hero__img" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
          </div>
        </div>
      </div>
      <div class="show-mobile">
        <img class="service-hero__img--mobile" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
        <div class="service-hero__stack--mobile">
          <nav aria-label="Drobečková navigace">
              <ol class="text-muted service-hero__meta">
                <li class="service-hero__item-2"><a class="service-hero__link" href="/#co-sijeme"><?= t('uvodni-blok.t1') ?></a><span aria-hidden="true"><?= t('uvodni-blok.t2') ?></span></li>
                <li class="service-hero__item" aria-current="page"><?= t('uvodni-blok.t3') ?></li>
              </ol>
            </nav>
          <h1 class="serif service-hero__title" id="hero-h1"><?= t('uvodni-blok.t4') ?></h1>
          <p class="text service-hero__text"><?= t('uvodni-blok.t5') ?></p>
          <div class="service-hero__row">
            <a class="btn-primary service-hero__btn--mobile" href="#poptavka"><?= t('uvodni-blok.t6') ?></a>
            <a class="btn-secondary service-hero__btn" href="tel:+420603287803"><?= t('uvodni-blok.t7') ?></a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('loga-klientu')): ?>
    <section class="pruh-log" data-screen-label="Pruh log" aria-label="Reference hotelů">
      <ul class="container pruh-log__inner">
        <li class="pruh-log__item"><img class="pruh-log__img" src="<?= img('loga-klientu.img1') ?>" alt="<?= alt('loga-klientu.img1') ?>" decoding="async" loading="lazy"></li>
        <li class="pruh-log__item"><img class="pruh-log__img" src="<?= img('loga-klientu.img2') ?>" alt="<?= alt('loga-klientu.img2') ?>" decoding="async" loading="lazy"></li>
        <li class="pruh-log__item"><img class="pruh-log__img" src="<?= img('loga-klientu.img3') ?>" alt="<?= alt('loga-klientu.img3') ?>" decoding="async" loading="lazy"></li>
        <li class="pruh-log__item"><img class="pruh-log__img" src="<?= img('loga-klientu.img4') ?>" alt="<?= alt('loga-klientu.img4') ?>" decoding="async" loading="lazy"></li>
      </ul>
    </section>
    <?php endif; ?>
    <?php if (visible('pro-koho')): ?>
    <section class="hotelovy-textil-pro-koho" data-screen-label="Pro koho" aria-labelledby="h-prokoho">
      <div class="container section-pad hotelovy-textil-pro-koho__inner">
        <div class="hotelovy-textil-pro-koho__stack-2">
          <span class="rule hotelovy-textil-pro-koho__rule" aria-hidden="true"></span>
          <h2 class="title-section hotelovy-textil-pro-koho__heading" id="h-prokoho"><?= t('pro-koho.t1') ?></h2>
        </div>
        <div class="hotelovy-textil-pro-koho__grid">
            <div class="hotelovy-textil-pro-koho__stack">
              <h3 class="title-card"><?= t('pro-koho.t2') ?></h3>
              <p class="text"><?= t('pro-koho.t3') ?></p>
            </div>
            <div class="hotelovy-textil-pro-koho__stack">
              <h3 class="title-card"><?= t('pro-koho.t4') ?></h3>
              <p class="text"><?= t('pro-koho.t5') ?></p>
            </div>
            <div class="hotelovy-textil-pro-koho__stack">
              <h3 class="title-card"><?= t('pro-koho.t6') ?></h3>
              <p class="text"><?= t('pro-koho.t7') ?></p>
            </div>
            <div class="hotelovy-textil-pro-koho__stack">
              <h3 class="title-card"><?= t('pro-koho.t8') ?></h3>
              <p class="text"><?= t('pro-koho.t9') ?></p>
            </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('co-pro-hotely-sijeme')): ?>
    <section data-screen-label="Co pro hotely šijeme" aria-labelledby="h-cosijeme">
      <div class="container section-pad co-pro-hotely-sijeme__inner">
        <div class="co-pro-hotely-sijeme__stack">
          <span class="rule co-pro-hotely-sijeme__rule" aria-hidden="true"></span>
          <h2 class="title-section co-pro-hotely-sijeme__heading" id="h-cosijeme"><?= t('co-pro-hotely-sijeme.t1') ?></h2>
        </div>
        <ul class="co-pro-hotely-sijeme__list">
            <li class="co-pro-hotely-sijeme__item">
                <div class="co-pro-hotely-sijeme__media"><img class="img-cover" src="<?= img('co-pro-hotely-sijeme.img1') ?>" alt="<?= alt('co-pro-hotely-sijeme.img1') ?>" decoding="async" loading="lazy"></div>
              <div class="co-pro-hotely-sijeme__stack-2">
                <h3 class="title-card"><?= t('co-pro-hotely-sijeme.t2') ?></h3>
                <p class="text co-pro-hotely-sijeme__text"><?= t('co-pro-hotely-sijeme.t3') ?></p>
              </div>
            </li>
            <li class="co-pro-hotely-sijeme__item">
                <div class="co-pro-hotely-sijeme__media"><img class="img-cover" src="<?= img('co-pro-hotely-sijeme.img2') ?>" alt="<?= alt('co-pro-hotely-sijeme.img2') ?>" decoding="async" loading="lazy"></div>
              <div class="co-pro-hotely-sijeme__stack-2">
                <h3 class="title-card"><?= t('co-pro-hotely-sijeme.t4') ?></h3>
                <p class="text co-pro-hotely-sijeme__text"><?= t('co-pro-hotely-sijeme.t5') ?></p>
              </div>
            </li>
            <li class="co-pro-hotely-sijeme__item">
                <div class="co-pro-hotely-sijeme__media"><img class="img-cover" src="<?= img('co-pro-hotely-sijeme.img3') ?>" alt="<?= alt('co-pro-hotely-sijeme.img3') ?>" decoding="async" loading="lazy"></div>
              <div class="co-pro-hotely-sijeme__stack-2">
                <h3 class="title-card"><?= t('co-pro-hotely-sijeme.t6') ?></h3>
                <p class="text co-pro-hotely-sijeme__text"><?= t('co-pro-hotely-sijeme.t7') ?></p>
              </div>
            </li>
            <li class="co-pro-hotely-sijeme__item">
                <div class="co-pro-hotely-sijeme__media"><img class="img-cover" src="<?= img('co-pro-hotely-sijeme.img4') ?>" alt="<?= alt('co-pro-hotely-sijeme.img4') ?>" decoding="async" loading="lazy"></div>
              <div class="co-pro-hotely-sijeme__stack-2">
                <h3 class="title-card"><?= t('co-pro-hotely-sijeme.t8') ?></h3>
                <p class="text co-pro-hotely-sijeme__text"><?= t('co-pro-hotely-sijeme.t9') ?></p>
              </div>
            </li>
            <li class="co-pro-hotely-sijeme__item">
                <div class="co-pro-hotely-sijeme__media"><img class="img-cover" src="<?= img('co-pro-hotely-sijeme.img5') ?>" alt="<?= alt('co-pro-hotely-sijeme.img5') ?>" decoding="async" loading="lazy"></div>
              <div class="co-pro-hotely-sijeme__stack-2">
                <h3 class="title-card"><?= t('co-pro-hotely-sijeme.t10') ?></h3>
                <p class="text co-pro-hotely-sijeme__text"><?= t('co-pro-hotely-sijeme.t11') ?></p>
              </div>
            </li>
            <li class="co-pro-hotely-sijeme__item">
                <div class="co-pro-hotely-sijeme__media"><img class="img-cover" src="<?= img('co-pro-hotely-sijeme.img6') ?>" alt="<?= alt('co-pro-hotely-sijeme.img6') ?>" decoding="async" loading="lazy"></div>
              <div class="co-pro-hotely-sijeme__stack-2">
                <h3 class="title-card"><?= t('co-pro-hotely-sijeme.t12') ?></h3>
                <p class="text co-pro-hotely-sijeme__text"><?= t('co-pro-hotely-sijeme.t13') ?></p>
                <a class="link-arrow co-pro-hotely-sijeme__link" href="/matracove-chranice-a-potahy/"><?= t('co-pro-hotely-sijeme.t14') ?></a>
              </div>
            </li>
        </ul>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('nehorlave-materialy')): ?>
    <section class="nehorlave-materialy" data-screen-label="Nehořlavé materiály" aria-labelledby="h-nehorlave">
      <div class="container section-pad nehorlave-materialy__inner">
        <div class="nehorlave-materialy__stack">
          <span class="eyebrow nehorlave-materialy__eyebrow"><?= t('nehorlave-materialy.t1') ?></span>
          <span class="rule nehorlave-materialy__rule" aria-hidden="true"></span>
          <h2 class="serif nehorlave-materialy__heading" id="h-nehorlave"><?= t('nehorlave-materialy.t2') ?></h2>
          <p class="text nehorlave-materialy__text"><?= rich('nehorlave-materialy.r1') ?></p>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('jak-spolupracujeme-s-hotely')): ?>
    <section data-screen-label="Jak spolupracujeme s hotely" aria-labelledby="h-postup">
      <div class="container section-pad jak-spolupracujeme-s-hotely__inner">
        <div class="jak-spolupracujeme-s-hotely__box">
          <img class="img-cover jak-spolupracujeme-s-hotely__img" src="<?= img('jak-spolupracujeme-s-hotely.img1') ?>" alt="<?= alt('jak-spolupracujeme-s-hotely.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="jak-spolupracujeme-s-hotely__stack-3">
          <div class="jak-spolupracujeme-s-hotely__stack">
          <span class="rule jak-spolupracujeme-s-hotely__rule" aria-hidden="true"></span>
          <h2 class="title-section jak-spolupracujeme-s-hotely__heading" id="h-postup"><?= t('jak-spolupracujeme-s-hotely.t1') ?></h2>
        </div>
          <ol class="jak-spolupracujeme-s-hotely__list">
              <li class="jak-spolupracujeme-s-hotely__item">
                <span class="serif jak-spolupracujeme-s-hotely__label"><?= t('jak-spolupracujeme-s-hotely.t2') ?></span>
                <div class="jak-spolupracujeme-s-hotely__stack-2">
                  <h3 class="serif jak-spolupracujeme-s-hotely__subheading"><?= t('jak-spolupracujeme-s-hotely.t3') ?></h3>
                  <p class="text"><?= t('jak-spolupracujeme-s-hotely.t4') ?></p>
                </div>
              </li>
              <li class="jak-spolupracujeme-s-hotely__item">
                <span class="serif jak-spolupracujeme-s-hotely__label"><?= t('jak-spolupracujeme-s-hotely.t5') ?></span>
                <div class="jak-spolupracujeme-s-hotely__stack-2">
                  <h3 class="serif jak-spolupracujeme-s-hotely__subheading"><?= t('jak-spolupracujeme-s-hotely.t6') ?></h3>
                  <p class="text"><?= t('jak-spolupracujeme-s-hotely.t7') ?></p>
                </div>
              </li>
              <li class="jak-spolupracujeme-s-hotely__item">
                <span class="serif jak-spolupracujeme-s-hotely__label"><?= t('jak-spolupracujeme-s-hotely.t8') ?></span>
                <div class="jak-spolupracujeme-s-hotely__stack-2">
                  <h3 class="serif jak-spolupracujeme-s-hotely__subheading"><?= t('jak-spolupracujeme-s-hotely.t9') ?></h3>
                  <p class="text"><?= rich('jak-spolupracujeme-s-hotely.r1') ?></p>
                </div>
              </li>
              <li class="jak-spolupracujeme-s-hotely__item">
                <span class="serif jak-spolupracujeme-s-hotely__label"><?= t('jak-spolupracujeme-s-hotely.t10') ?></span>
                <div class="jak-spolupracujeme-s-hotely__stack-2">
                  <h3 class="serif jak-spolupracujeme-s-hotely__subheading"><?= t('jak-spolupracujeme-s-hotely.t11') ?></h3>
                  <p class="text"><?= t('jak-spolupracujeme-s-hotely.t12') ?></p>
                </div>
              </li>
              <li class="jak-spolupracujeme-s-hotely__item">
                <span class="serif jak-spolupracujeme-s-hotely__label"><?= t('jak-spolupracujeme-s-hotely.t13') ?></span>
                <div class="jak-spolupracujeme-s-hotely__stack-2">
                  <h3 class="serif jak-spolupracujeme-s-hotely__subheading"><?= t('jak-spolupracujeme-s-hotely.t14') ?></h3>
                  <p class="text"><?= rich('jak-spolupracujeme-s-hotely.r2') ?></p>
                </div>
              </li>
          </ol>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('reference')): ?>
    <section class="hotelovy-textil-reference" data-screen-label="Reference" aria-labelledby="h-reference">
      <div class="container section-pad hotelovy-textil-reference__inner">
        <div class="hotelovy-textil-reference__stack">
          <span class="eyebrow hotelovy-textil-reference__eyebrow"><?= t('reference.t1') ?></span>
          <span class="rule hotelovy-textil-reference__rule" aria-hidden="true"></span>
          <h2 class="title-section hotelovy-textil-reference__heading" id="h-reference"><?= t('reference.t2') ?></h2>
          <a class="btn-secondary hotelovy-textil-reference__btn" href="/reference/"><?= t('reference.t3') ?></a>
        </div>
        <ul class="hotelovy-textil-reference__list">
            <li class="hotelovy-textil-reference__item">
              <span class="serif hotelovy-textil-reference__label"><?= t('reference.t4') ?></span>
              <span class="text-muted"><?= t('reference.t5') ?></span>
            </li>
            <li class="hotelovy-textil-reference__item">
              <span class="serif hotelovy-textil-reference__label"><?= t('reference.t6') ?></span>
              <span class="text-muted"><?= t('reference.t5') ?></span>
            </li>
            <li class="hotelovy-textil-reference__item">
              <span class="serif hotelovy-textil-reference__label"><?= t('reference.t7') ?></span>
              <span class="text-muted"><?= t('reference.t5') ?></span>
            </li>
            <li class="hotelovy-textil-reference__item">
              <span class="serif hotelovy-textil-reference__label"><?= t('reference.t8') ?></span>
              <span class="text-muted"><?= t('reference.t9') ?></span>
            </li>
            <li class="hotelovy-textil-reference__item">
              <span class="serif hotelovy-textil-reference__label"><?= t('reference.t10') ?></span>
              <span class="text-muted"><?= t('reference.t5') ?></span>
            </li>
            <li class="hotelovy-textil-reference__item">
              <span class="serif hotelovy-textil-reference__label"><?= t('reference.t11') ?></span>
              <span class="text-muted"><?= t('reference.t5') ?></span>
            </li>
            <li class="hotelovy-textil-reference__item">
              <span class="serif hotelovy-textil-reference__label"><?= t('reference.t12') ?></span>
              <span class="text-muted"><?= t('reference.t13') ?></span>
            </li>
        </ul>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('caste-dotazy')): ?>
    <section data-screen-label="FAQ" aria-labelledby="h-faq">
      <div class="container section-pad hotelovy-textil-faq__inner">
        <div class="hotelovy-textil-faq__stack">
          <span class="rule hotelovy-textil-faq__rule" aria-hidden="true"></span>
          <h2 class="title-section hotelovy-textil-faq__heading" id="h-faq"><?= t('caste-dotazy.t1') ?></h2>
        </div>
        <div class="hotelovy-textil-faq__box-2">
            <div class="hotelovy-textil-faq__box">
              <h3 class="hotelovy-textil-faq__subheading">
                <button class="serif hotelovy-textil-faq__btn" type="button" data-on-click="f.toggle" data-idx="0" aria-expanded="true">
                  <?= rich('caste-dotazy.r1') ?>
                  <span class="hotelovy-textil-faq__label" aria-hidden="true"><?= t('caste-dotazy.t2') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="0">
                <div class="hotelovy-textil-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t3') ?></p>
                </div>
              </div>
            </div>
            <div class="hotelovy-textil-faq__box">
              <h3 class="hotelovy-textil-faq__subheading">
                <button class="serif hotelovy-textil-faq__btn" type="button" data-on-click="f.toggle" data-idx="1" aria-expanded="false">
                  <?= rich('caste-dotazy.r2') ?>
                  <span class="hotelovy-textil-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="1" hidden>
                <div class="hotelovy-textil-faq__box-3">
                  <mark class="todo hotelovy-textil-faq__note-2"><?= t('caste-dotazy.t5') ?></mark>
                </div>
              </div>
            </div>
            <div class="hotelovy-textil-faq__box">
              <h3 class="hotelovy-textil-faq__subheading">
                <button class="serif hotelovy-textil-faq__btn" type="button" data-on-click="f.toggle" data-idx="2" aria-expanded="false">
                  <?= rich('caste-dotazy.r3') ?>
                  <span class="hotelovy-textil-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="2" hidden>
                <div class="hotelovy-textil-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t6') ?></p>
                </div>
              </div>
            </div>
            <div class="hotelovy-textil-faq__box">
              <h3 class="hotelovy-textil-faq__subheading">
                <button class="serif hotelovy-textil-faq__btn" type="button" data-on-click="f.toggle" data-idx="3" aria-expanded="false">
                  <?= rich('caste-dotazy.r4') ?>
                  <span class="hotelovy-textil-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="3" hidden>
                <div class="hotelovy-textil-faq__box-3">
                  <p class="text"><?= rich('caste-dotazy.r5') ?></p>
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('poptavka')): ?>
    <section class="service-poptavka" data-screen-label="Poptávka">
      <div class="container section-pad">
        <div class="inquiry" data-c="PoptavkovyFormular" data-p-heading="Připravujete otevření nebo rekonstrukci?" data-p-intro="Napište nám počet pokojů a co potřebujete vybavit. Ozveme se a domluvíme schůzku." data-p-service="Hotelový textil" data-p-placeholder="Např. 40 pokojů – závěsy, přehozy a polštáře, otevření na jaře…" id="poptavka">
  <form class="inquiry__form" data-on-submit="submit" data-thanks="/dekujeme/" novalidate action="/odeslat/poptavka/" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?= form_token() ?>">
    <div class="form-hp" aria-hidden="true"><label>Nevyplňujte <input type="text" name="web" tabindex="-1" autocomplete="off"></label></div>
    <p class="form-alert" id="formular-chyba" role="alert" hidden></p>
    <div class="inquiry__intro">
      <h2 class="title-section"><?= t('poptavka.t1') ?></h2>
        <p class="text inquiry__lead"><?= t('poptavka.t2') ?></p>
    </div>
    <label class="inquiry__field">
      <span class="inquiry__field-label">O jakou službu jde?</span>
      <span class="inquiry__select-wrap">
        <select class="field inquiry__select" name="service">
          <option value="">—</option>
          <option>Bytový textil</option>
          <option selected>Hotelový textil</option>
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
      <textarea class="field inquiry__textarea" rows="5" placeholder="Např. 40 pokojů – závěsy, přehozy a polštáře, otevření na jaře…" aria-invalid="false" name="message"></textarea>
      <span data-if="e.message" hidden><span class="inquiry__error">Vyplňte prosím toto pole.</span></span>
    </label>
    <div class="inquiry__file">
      <span class="inquiry__field-label"><?= t('poptavka.t3') ?></span>
      <label class="inquiry__file-drop">
        <input class="inquiry__file-input" type="file" data-on-change="onFile" name="attachment">
        <span class="btn-secondary inquiry__file-btn">Vybrat soubor</span>
        <span class="text-muted inquiry__file-name"></span>
      </label>
      <div data-if="e.file" hidden><span class="inquiry__error">Soubor je větší než 10 MB.</span></div>
    </div>
    <p class="text-muted inquiry__consent"><?= rich('poptavka.r1') ?></p>
    <button class="btn-primary inquiry__submit" type="submit">Odeslat poptávku</button>
  </form>
  <aside class="inquiry__aside">
    <span class="serif inquiry__aside-title"><?= t('poptavka.t4') ?></span>
    <a class="serif inquiry__aside-phone" href="tel:+420603287803"><?= t('poptavka.t5') ?></a>
    <a class="inquiry__aside-email" href="mailto:info@century2000.cz"><?= t('poptavka.t6') ?></a>
    <span class="inquiry__aside-hours"><?= t('poptavka.t7') ?></span>
  </aside>
</div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('souvisejici-sluzby')): ?>
    <section data-screen-label="Související služby" aria-labelledby="h-souvisejici">
      <div class="container section-pad service-souvisejici-sluzby__inner">
        <div class="service-souvisejici-sluzby__stack">
          <span class="rule service-souvisejici-sluzby__rule" aria-hidden="true"></span>
          <h2 class="title-section service-souvisejici-sluzby__heading" id="h-souvisejici"><?= t('souvisejici-sluzby.t1') ?></h2>
        </div>
        <div class="service-souvisejici-sluzby__row">
          <div class="service-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/matracove-chranice-a-potahy/">
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
          <div class="service-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/latky-a-metraz/">
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
