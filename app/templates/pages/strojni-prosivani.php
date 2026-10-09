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
              <a class="btn-secondary service-hero__btn--desktop" href="#parametry"><?= t('uvodni-blok.t7') ?></a>
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
            <a class="btn-secondary service-hero__btn" href="#parametry"><?= t('uvodni-blok.t7') ?></a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('z-ceho-se-prosivany-material-sklada')): ?>
    <section data-screen-label="Z čeho se prošívaný materiál skládá" aria-labelledby="h-vrstvy">
      <div class="container section-pad z-ceho-se-prosivany-material-sklada__inner">
        <div class="z-ceho-se-prosivany-material-sklada__box">
          <img class="img-cover z-ceho-se-prosivany-material-sklada__img" src="<?= img('z-ceho-se-prosivany-material-sklada.img1') ?>" alt="<?= alt('z-ceho-se-prosivany-material-sklada.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="z-ceho-se-prosivany-material-sklada__stack-3">
          <div class="z-ceho-se-prosivany-material-sklada__stack">
          <span class="eyebrow z-ceho-se-prosivany-material-sklada__eyebrow"><?= t('z-ceho-se-prosivany-material-sklada.t1') ?></span>
          <span class="rule z-ceho-se-prosivany-material-sklada__rule" aria-hidden="true"></span>
          <h2 class="title-section z-ceho-se-prosivany-material-sklada__heading" id="h-vrstvy"><?= t('z-ceho-se-prosivany-material-sklada.t2') ?></h2>
        </div>
          <ol class="z-ceho-se-prosivany-material-sklada__list">
              <li class="z-ceho-se-prosivany-material-sklada__item">
                <span class="serif z-ceho-se-prosivany-material-sklada__label"><?= t('z-ceho-se-prosivany-material-sklada.t3') ?></span>
                <div class="z-ceho-se-prosivany-material-sklada__stack-2">
                  <h3 class="serif z-ceho-se-prosivany-material-sklada__subheading"><?= t('z-ceho-se-prosivany-material-sklada.t4') ?></h3>
                  <p class="text"><?= t('z-ceho-se-prosivany-material-sklada.t5') ?></p>
                </div>
              </li>
              <li class="z-ceho-se-prosivany-material-sklada__item">
                <span class="serif z-ceho-se-prosivany-material-sklada__label"><?= t('z-ceho-se-prosivany-material-sklada.t6') ?></span>
                <div class="z-ceho-se-prosivany-material-sklada__stack-2">
                  <h3 class="serif z-ceho-se-prosivany-material-sklada__subheading"><?= t('z-ceho-se-prosivany-material-sklada.t7') ?></h3>
                  <p class="text"><?= t('z-ceho-se-prosivany-material-sklada.t8') ?></p>
                </div>
              </li>
              <li class="z-ceho-se-prosivany-material-sklada__item">
                <span class="serif z-ceho-se-prosivany-material-sklada__label"><?= t('z-ceho-se-prosivany-material-sklada.t9') ?></span>
                <div class="z-ceho-se-prosivany-material-sklada__stack-2">
                  <h3 class="serif z-ceho-se-prosivany-material-sklada__subheading"><?= t('z-ceho-se-prosivany-material-sklada.t10') ?></h3>
                  <p class="text"><?= t('z-ceho-se-prosivany-material-sklada.t11') ?></p>
                </div>
              </li>
          </ol>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('technicke-parametry')): ?>
    <section class="technicke-parametry" id="parametry" data-screen-label="Technické parametry" aria-labelledby="h-parametry">
      <div class="container section-pad technicke-parametry__inner">
        <div class="technicke-parametry__box"><div class="technicke-parametry__stack">
          <span class="rule technicke-parametry__rule" aria-hidden="true"></span>
          <h2 class="title-section technicke-parametry__heading" id="h-parametry"><?= t('technicke-parametry.t1') ?></h2>
        </div></div>
        <dl class="technicke-parametry__facts">
            <div class="technicke-parametry__grid">
              <dt class="technicke-parametry__term"><?= t('technicke-parametry.t2') ?></dt>
              <dd class="technicke-parametry__value"><?= rich('technicke-parametry.r1') ?></dd>
            </div>
            <div class="technicke-parametry__grid">
              <dt class="technicke-parametry__term"><?= t('technicke-parametry.t3') ?></dt>
              <dd class="technicke-parametry__value"><?= t('technicke-parametry.t4') ?></dd>
            </div>
            <div class="technicke-parametry__grid">
              <dt class="technicke-parametry__term"><?= t('technicke-parametry.t5') ?></dt>
              <dd class="technicke-parametry__value"><?= t('technicke-parametry.t6') ?></dd>
            </div>
            <div class="technicke-parametry__grid">
              <dt class="technicke-parametry__term"><?= t('technicke-parametry.t7') ?></dt>
              <dd class="technicke-parametry__value"><?= t('technicke-parametry.t8') ?></dd>
            </div>
            <div class="technicke-parametry__grid">
              <dt class="technicke-parametry__term"><?= t('technicke-parametry.t9') ?></dt>
              <dd class="technicke-parametry__value"><?= t('technicke-parametry.t10') ?></dd>
            </div>
        </dl>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('stroje')): ?>
    <section data-screen-label="Stroje" aria-labelledby="h-stroje">
      <div class="container section-pad stroje__inner">
        <div class="stroje__stack">
          <span class="rule stroje__rule" aria-hidden="true"></span>
          <h2 class="title-section stroje__heading" id="h-stroje"><?= t('stroje.t1') ?></h2>
        </div>
        <ul class="stroje__list">
            <li class="stroje__item">
                <div class="stroje__media"><img class="img-cover" src="<?= img('stroje.img1') ?>" alt="<?= alt('stroje.img1') ?>" decoding="async" loading="lazy"></div>
              <div class="stroje__stack-2">
                <h3 class="title-card"><?= t('stroje.t2') ?></h3>
                <p class="text stroje__text"><?= t('stroje.t3') ?></p>
              </div>
            </li>
            <li class="stroje__item">
                <div class="stroje__media"><img class="img-cover" src="<?= img('stroje.img2') ?>" alt="<?= alt('stroje.img2') ?>" decoding="async" loading="lazy"></div>
              <div class="stroje__stack-2">
                <h3 class="title-card"><?= t('stroje.t4') ?></h3>
                <p class="text stroje__text"><?= t('stroje.t5') ?></p>
              </div>
            </li>
        </ul>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('vzornik-prosevu')): ?>
    <section class="vzornik-prosevu" data-screen-label="Vzorník proševu" aria-labelledby="h-vzory">
      <div class="container section-pad vzornik-prosevu__inner">
        <div class="vzornik-prosevu__stack">
          <span class="eyebrow vzornik-prosevu__eyebrow"><?= t('vzornik-prosevu.t1') ?></span>
          <span class="rule vzornik-prosevu__rule" aria-hidden="true"></span>
          <h2 class="title-section vzornik-prosevu__heading" id="h-vzory"><?= t('vzornik-prosevu.t2') ?></h2>
        </div>
        <ul class="vzornik-prosevu__list">
            <li>
              <figure class="vzornik-prosevu__figure">
                <div class="vzornik-prosevu__media"><img class="img-cover" src="<?= img('vzornik-prosevu.img1') ?>" alt="<?= alt('vzornik-prosevu.img1') ?>" decoding="async" loading="lazy"></div>
                <figcaption class="serif vzornik-prosevu__caption"><?= t('vzornik-prosevu.t3') ?></figcaption>
              </figure>
            </li>
            <li>
              <figure class="vzornik-prosevu__figure">
                <div class="vzornik-prosevu__media"><img class="img-cover" src="<?= img('vzornik-prosevu.img2') ?>" alt="<?= alt('vzornik-prosevu.img2') ?>" decoding="async" loading="lazy"></div>
                <figcaption class="serif vzornik-prosevu__caption"><?= t('vzornik-prosevu.t4') ?></figcaption>
              </figure>
            </li>
            <li>
              <figure class="vzornik-prosevu__figure">
                <div class="vzornik-prosevu__media"><img class="img-cover" src="<?= img('vzornik-prosevu.img3') ?>" alt="<?= alt('vzornik-prosevu.img3') ?>" decoding="async" loading="lazy"></div>
                <figcaption class="serif vzornik-prosevu__caption"><?= t('vzornik-prosevu.t5') ?></figcaption>
              </figure>
            </li>
            <li>
              <figure class="vzornik-prosevu__figure">
                <div class="vzornik-prosevu__media"><img class="img-cover" src="<?= img('vzornik-prosevu.img4') ?>" alt="<?= alt('vzornik-prosevu.img4') ?>" decoding="async" loading="lazy"></div>
                <figcaption class="serif vzornik-prosevu__caption"><?= t('vzornik-prosevu.t6') ?></figcaption>
              </figure>
            </li>
            <li>
              <figure class="vzornik-prosevu__figure">
                <div class="vzornik-prosevu__media"><img class="img-cover" src="<?= img('vzornik-prosevu.img5') ?>" alt="<?= alt('vzornik-prosevu.img5') ?>" decoding="async" loading="lazy"></div>
                <figcaption class="serif vzornik-prosevu__caption"><?= t('vzornik-prosevu.t7') ?></figcaption>
              </figure>
            </li>
            <li>
              <figure class="vzornik-prosevu__figure">
                <div class="vzornik-prosevu__media"><img class="img-cover" src="<?= img('vzornik-prosevu.img6') ?>" alt="<?= alt('vzornik-prosevu.img6') ?>" decoding="async" loading="lazy"></div>
                <figcaption class="serif vzornik-prosevu__caption"><?= t('vzornik-prosevu.t8') ?></figcaption>
              </figure>
            </li>
        </ul>
        <p class="text-muted vzornik-prosevu__meta"><?= rich('vzornik-prosevu.r1') ?></p>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('co-potrebujeme-k-naceneni')): ?>
    <section data-screen-label="Co potřebujeme k nacenění" aria-labelledby="h-naceneni">
      <div class="container section-pad co-potrebujeme-k-naceneni__inner">
        <div class="co-potrebujeme-k-naceneni__box">
          <img class="img-cover co-potrebujeme-k-naceneni__img" src="<?= img('co-potrebujeme-k-naceneni.img1') ?>" alt="<?= alt('co-potrebujeme-k-naceneni.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="co-potrebujeme-k-naceneni__stack-3">
          <div class="co-potrebujeme-k-naceneni__stack">
          <span class="rule co-potrebujeme-k-naceneni__rule" aria-hidden="true"></span>
          <h2 class="title-section co-potrebujeme-k-naceneni__heading" id="h-naceneni"><?= t('co-potrebujeme-k-naceneni.t1') ?></h2>
        </div>
          <ol class="co-potrebujeme-k-naceneni__list">
              <li class="co-potrebujeme-k-naceneni__item">
                <span class="serif co-potrebujeme-k-naceneni__label"><?= t('co-potrebujeme-k-naceneni.t2') ?></span>
                <div class="co-potrebujeme-k-naceneni__stack-2">
                  <p class="text"><?= t('co-potrebujeme-k-naceneni.t3') ?></p>
                </div>
              </li>
              <li class="co-potrebujeme-k-naceneni__item">
                <span class="serif co-potrebujeme-k-naceneni__label"><?= t('co-potrebujeme-k-naceneni.t4') ?></span>
                <div class="co-potrebujeme-k-naceneni__stack-2">
                  <p class="text"><?= t('co-potrebujeme-k-naceneni.t5') ?></p>
                </div>
              </li>
              <li class="co-potrebujeme-k-naceneni__item">
                <span class="serif co-potrebujeme-k-naceneni__label"><?= t('co-potrebujeme-k-naceneni.t6') ?></span>
                <div class="co-potrebujeme-k-naceneni__stack-2">
                  <p class="text"><?= t('co-potrebujeme-k-naceneni.t7') ?></p>
                </div>
              </li>
              <li class="co-potrebujeme-k-naceneni__item">
                <span class="serif co-potrebujeme-k-naceneni__label"><?= t('co-potrebujeme-k-naceneni.t8') ?></span>
                <div class="co-potrebujeme-k-naceneni__stack-2">
                  <p class="text"><?= t('co-potrebujeme-k-naceneni.t9') ?></p>
                </div>
              </li>
              <li class="co-potrebujeme-k-naceneni__item">
                <span class="serif co-potrebujeme-k-naceneni__label"><?= t('co-potrebujeme-k-naceneni.t10') ?></span>
                <div class="co-potrebujeme-k-naceneni__stack-2">
                  <p class="text"><?= t('co-potrebujeme-k-naceneni.t11') ?></p>
                </div>
              </li>
          </ol>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('caste-dotazy')): ?>
    <section class="strojni-prosivani-faq" data-screen-label="FAQ" aria-labelledby="h-faq">
      <div class="container section-pad strojni-prosivani-faq__inner">
        <div class="strojni-prosivani-faq__stack">
          <span class="rule strojni-prosivani-faq__rule" aria-hidden="true"></span>
          <h2 class="title-section strojni-prosivani-faq__heading" id="h-faq"><?= t('caste-dotazy.t1') ?></h2>
        </div>
        <div class="strojni-prosivani-faq__box-2">
            <div class="strojni-prosivani-faq__box">
              <h3 class="strojni-prosivani-faq__subheading">
                <button class="serif strojni-prosivani-faq__btn" type="button" data-on-click="f.toggle" data-idx="0" aria-expanded="true">
                  <?= rich('caste-dotazy.r1') ?>
                  <span class="strojni-prosivani-faq__label" aria-hidden="true"><?= t('caste-dotazy.t2') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="0">
                <div class="strojni-prosivani-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t3') ?></p>
                </div>
              </div>
            </div>
            <div class="strojni-prosivani-faq__box">
              <h3 class="strojni-prosivani-faq__subheading">
                <button class="serif strojni-prosivani-faq__btn" type="button" data-on-click="f.toggle" data-idx="1" aria-expanded="false">
                  <?= rich('caste-dotazy.r2') ?>
                  <span class="strojni-prosivani-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="1" hidden>
                <div class="strojni-prosivani-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t5') ?></p>
                </div>
              </div>
            </div>
            <div class="strojni-prosivani-faq__box">
              <h3 class="strojni-prosivani-faq__subheading">
                <button class="serif strojni-prosivani-faq__btn" type="button" data-on-click="f.toggle" data-idx="2" aria-expanded="false">
                  <?= rich('caste-dotazy.r3') ?>
                  <span class="strojni-prosivani-faq__label" aria-hidden="true"><?= t('caste-dotazy.t4') ?></span>
                </button>
              </h3>
              <div data-if="f.open" data-idx="2" hidden>
                <div class="strojni-prosivani-faq__box-3">
                  <p class="text"><?= t('caste-dotazy.t6') ?></p>
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
        <div class="inquiry" data-c="PoptavkovyFormular" data-p-heading="Pošlete nám parametry, spočítáme cenu" data-p-service="Strojní prošívání" data-p-placeholder="Materiál, gramáž rouna, vzor, šířka, metráž, termín…" id="poptavka">
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
          <option selected>Strojní prošívání</option>
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
      <textarea class="field inquiry__textarea" rows="5" placeholder="Materiál, gramáž rouna, vzor, šířka, metráž, termín…" aria-invalid="false" name="message"></textarea>
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
