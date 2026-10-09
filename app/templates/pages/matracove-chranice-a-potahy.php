<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="matracove-chranice-a-potahy-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="show-desktop">
        <div class="matracove-chranice-a-potahy-hero__grid">
          <div class="matracove-chranice-a-potahy-hero__stack">
            <nav aria-label="Drobečková navigace">
              <ol class="text-muted matracove-chranice-a-potahy-hero__meta">
                <li class="matracove-chranice-a-potahy-hero__item-2"><a class="matracove-chranice-a-potahy-hero__link" href="/#co-sijeme"><?= t('uvodni-blok.t1') ?></a><span aria-hidden="true"><?= t('uvodni-blok.t2') ?></span></li>
                <li class="matracove-chranice-a-potahy-hero__item" aria-current="page"><?= t('uvodni-blok.t3') ?></li>
              </ol>
            </nav>
            <h1 class="title-hero matracove-chranice-a-potahy-hero__title--desktop" id="hero-h1"><?= t('uvodni-blok.t4') ?></h1>
            <p class="text matracove-chranice-a-potahy-hero__text--desktop"><?= t('uvodni-blok.t5') ?></p>
            <div class="matracove-chranice-a-potahy-hero__row--desktop">
              <a class="btn-primary matracove-chranice-a-potahy-hero__btn--desktop" href="#poptavka"><?= t('uvodni-blok.t6') ?></a>
            </div>
          </div>
          <div class="matracove-chranice-a-potahy-hero__box">
            <img class="img-cover matracove-chranice-a-potahy-hero__img" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
          </div>
        </div>
      </div>
      <div class="show-mobile">
        <img class="matracove-chranice-a-potahy-hero__img--mobile" src="<?= img('uvodni-blok.img1') ?>" alt="<?= alt('uvodni-blok.img1') ?>" decoding="async">
        <div class="matracove-chranice-a-potahy-hero__stack--mobile">
          <nav aria-label="Drobečková navigace">
              <ol class="text-muted matracove-chranice-a-potahy-hero__meta">
                <li class="matracove-chranice-a-potahy-hero__item-2"><a class="matracove-chranice-a-potahy-hero__link" href="/#co-sijeme"><?= t('uvodni-blok.t1') ?></a><span aria-hidden="true"><?= t('uvodni-blok.t2') ?></span></li>
                <li class="matracove-chranice-a-potahy-hero__item" aria-current="page"><?= t('uvodni-blok.t3') ?></li>
              </ol>
            </nav>
          <h1 class="serif matracove-chranice-a-potahy-hero__title" id="hero-h1"><?= t('uvodni-blok.t4') ?></h1>
          <p class="text matracove-chranice-a-potahy-hero__text"><?= t('uvodni-blok.t5') ?></p>
          <div class="matracove-chranice-a-potahy-hero__row">
            <a class="btn-primary matracove-chranice-a-potahy-hero__btn" href="#poptavka"><?= t('uvodni-blok.t6') ?></a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('produkty')): ?>
    <section data-screen-label="Produkty" aria-labelledby="h-produkty">
      <div class="container section-pad produkty__inner">
        <div class="produkty__stack">
          <span class="rule produkty__rule" aria-hidden="true"></span>
          <h2 class="title-section produkty__heading" id="h-produkty"><?= t('produkty.t1') ?></h2>
        </div>
        <ul class="produkty__list">
            <li class="produkty__item">
                <div class="produkty__media"><img class="img-cover" src="<?= img('produkty.img1') ?>" alt="<?= alt('produkty.img1') ?>" decoding="async" loading="lazy"></div>
              <div class="produkty__stack-2">
                <h3 class="title-card"><?= t('produkty.t2') ?></h3>
                <p class="text produkty__text"><?= t('produkty.t3') ?></p>
              </div>
            </li>
            <li class="produkty__item">
                <div class="produkty__media"><img class="img-cover" src="<?= img('produkty.img2') ?>" alt="<?= alt('produkty.img2') ?>" decoding="async" loading="lazy"></div>
              <div class="produkty__stack-2">
                <h3 class="title-card"><?= t('produkty.t4') ?></h3>
                <p class="text produkty__text"><?= t('produkty.t5') ?></p>
              </div>
            </li>
            <li class="produkty__item">
                <div class="produkty__media"><img class="img-cover" src="<?= img('produkty.img3') ?>" alt="<?= alt('produkty.img3') ?>" decoding="async" loading="lazy"></div>
              <div class="produkty__stack-2">
                <h3 class="title-card"><?= t('produkty.t6') ?></h3>
                <p class="text produkty__text"><?= t('produkty.t7') ?></p>
              </div>
            </li>
            <li class="produkty__item">
                <div class="produkty__media"><img class="img-cover" src="<?= img('produkty.img4') ?>" alt="<?= alt('produkty.img4') ?>" decoding="async" loading="lazy"></div>
              <div class="produkty__stack-2">
                <h3 class="title-card"><?= t('produkty.t8') ?></h3>
                <p class="text produkty__text"><?= t('produkty.t9') ?></p>
              </div>
            </li>
        </ul>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('pro-koho')): ?>
    <section class="matracove-chranice-a-potahy-pro-koho" data-screen-label="Pro koho" aria-labelledby="h-prokoho">
      <div class="container section-pad matracove-chranice-a-potahy-pro-koho__inner">
        <div class="matracove-chranice-a-potahy-pro-koho__stack-2">
          <span class="rule matracove-chranice-a-potahy-pro-koho__rule" aria-hidden="true"></span>
          <h2 class="title-section matracove-chranice-a-potahy-pro-koho__heading" id="h-prokoho"><?= t('pro-koho.t1') ?></h2>
        </div>
        <div class="matracove-chranice-a-potahy-pro-koho__grid">
            <div class="matracove-chranice-a-potahy-pro-koho__stack">
              <h3 class="title-card"><?= t('pro-koho.t2') ?></h3>
              <p class="text"><?= t('pro-koho.t3') ?></p>
            </div>
            <div class="matracove-chranice-a-potahy-pro-koho__stack">
              <h3 class="title-card"><?= t('pro-koho.t4') ?></h3>
              <p class="text"><?= rich('pro-koho.r1') ?></p>
            </div>
            <div class="matracove-chranice-a-potahy-pro-koho__stack">
              <h3 class="title-card"><?= t('pro-koho.t5') ?></h3>
              <p class="text"><?= t('pro-koho.t6') ?></p>
            </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('vlastni-prosev')): ?>
    <section class="vlastni-prosev" data-screen-label="Vlastní prošev" aria-labelledby="h-prosev">
      <div class="container section-pad vlastni-prosev__inner">
        <div class="vlastni-prosev__stack">
          <span class="eyebrow vlastni-prosev__eyebrow"><?= t('vlastni-prosev.t1') ?></span>
          <span class="rule vlastni-prosev__rule" aria-hidden="true"></span>
          <h2 class="serif vlastni-prosev__heading" id="h-prosev"><?= t('vlastni-prosev.t2') ?></h2>
          <p class="text vlastni-prosev__text"><?= t('vlastni-prosev.t3') ?></p>
        </div>
        <a class="btn-primary vlastni-prosev__btn" href="/strojni-prosivani/"><?= t('vlastni-prosev.t4') ?></a>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('rozmery')): ?>
    <section data-screen-label="Rozměry" aria-labelledby="h-rozmery">
      <div class="container section-pad rozmery__inner">
        <div class="rozmery__box"><div class="rozmery__stack">
          <span class="rule rozmery__rule" aria-hidden="true"></span>
          <h2 class="title-section rozmery__heading" id="h-rozmery"><?= t('rozmery.t1') ?></h2>
        </div></div>
        <p class="text rozmery__text"><?= rich('rozmery.r1') ?></p>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('poptavka')): ?>
    <section class="service-poptavka" data-screen-label="Poptávka">
      <div class="container section-pad">
        <div class="inquiry" data-c="PoptavkovyFormular" data-p-heading="Napište rozměry a počet kusů" data-p-service="Matracové chrániče a potahy" data-p-placeholder="Např. 60 chráničů s PUR zátěrem, 90 × 200 cm, výška matrace 20 cm…" id="poptavka">
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
          <option>Bytový textil</option>
          <option>Hotelový textil</option>
          <option>Strojní prošívání</option>
          <option selected>Matracové chrániče a potahy</option>
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
      <textarea class="field inquiry__textarea" rows="5" placeholder="Např. 60 chráničů s PUR zátěrem, 90 × 200 cm, výška matrace 20 cm…" aria-invalid="false" name="message"></textarea>
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
      <div class="container section-pad service-souvisejici-sluzby__inner">
        <div class="service-souvisejici-sluzby__stack">
          <span class="rule service-souvisejici-sluzby__rule" aria-hidden="true"></span>
          <h2 class="title-section service-souvisejici-sluzby__heading" id="h-souvisejici"><?= t('souvisejici-sluzby.t1') ?></h2>
        </div>
        <div class="service-souvisejici-sluzby__row">
          <div class="service-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/strojni-prosivani/">
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
          <div class="service-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/hotelovy-textil/">
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
