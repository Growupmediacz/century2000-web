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
              <a class="btn-secondary service-hero__btn--desktop" href="https://century2000-cz.webnode.cz" target="_blank" rel="noopener"><?= t('uvodni-blok.t7') ?></a>
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
            <a class="btn-secondary service-hero__btn" href="https://century2000-cz.webnode.cz" target="_blank" rel="noopener"><?= t('uvodni-blok.t7') ?></a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('sortiment')): ?>
    <section data-screen-label="Sortiment" aria-labelledby="h-sortiment">
      <div class="container section-pad sortiment__inner">
        <div class="sortiment__box">
          <img class="img-cover sortiment__img" src="<?= img('sortiment.img1') ?>" alt="<?= alt('sortiment.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="sortiment__stack-3">
          <div class="sortiment__stack-2">
          <span class="rule sortiment__rule" aria-hidden="true"></span>
          <h2 class="title-section sortiment__heading" id="h-sortiment"><?= t('sortiment.t1') ?></h2>
        </div>
          <div class="sortiment__grid">
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t2') ?></h3>
              <p class="text"><?= t('sortiment.t3') ?></p>
            </div>
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t4') ?></h3>
              <p class="text"><?= t('sortiment.t5') ?></p>
            </div>
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t6') ?></h3>
              <p class="text"><?= t('sortiment.t7') ?></p>
            </div>
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t8') ?></h3>
              <p class="text"><?= t('sortiment.t9') ?></p>
            </div>
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t10') ?></h3>
              <p class="text"><?= t('sortiment.t11') ?></p>
            </div>
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t12') ?></h3>
              <p class="text"><?= t('sortiment.t13') ?></p>
            </div>
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t14') ?></h3>
              <p class="text"><?= t('sortiment.t15') ?></p>
            </div>
            <div class="sortiment__stack">
              <h3 class="title-card"><?= t('sortiment.t16') ?></h3>
              <p class="text"><?= t('sortiment.t17') ?></p>
            </div>
        </div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php $detail = body_blocks($page, 'text'); if ($detail): ?>
    <section aria-labelledby="h-detail" data-screen-label="Materiály podrobně">
      <div class="container section-pad latky-detail">
        <h2 class="title-section" id="h-detail">Materiály podrobně</h2>
        <?php foreach ($detail as $b): ?>
        <div class="latky-detail__item" id="<?= e($b['id']) ?>">
          <h3 class="title-card"><?= e($b['h']) ?></h3>
          <?php foreach ($b['paragraphs'] as $p): ?><p class="text"><?= $p ?></p><?php endforeach; ?>
          <?php if ($b['items']): ?><ul class="clanek-body__list"><?php foreach ($b['items'] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul><?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('vzorkovniky')): ?>
    <section class="vzorkovniky" data-screen-label="Vzorkovníky" aria-labelledby="h-vzorkovniky">
      <div class="container section-pad vzorkovniky__inner">
        <div class="vzorkovniky__box">
          <img class="img-cover vzorkovniky__img" src="<?= img('vzorkovniky.img1') ?>" alt="<?= alt('vzorkovniky.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="vzorkovniky__stack-2">
          <div class="vzorkovniky__stack">
          <span class="rule vzorkovniky__rule" aria-hidden="true"></span>
          <h2 class="title-section vzorkovniky__heading" id="h-vzorkovniky"><?= t('vzorkovniky.t1') ?></h2>
        </div>
          <p class="text vzorkovniky__text"><?= t('vzorkovniky.t2') ?></p>
          <a class="link-arrow" href="/vzorkovniky/">Vzorkovníky ke stažení (PDF) →</a>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('prodejna')): ?>
    <section class="prodejna" data-screen-label="Prodejna" aria-labelledby="h-prodejna">
      <div class="container section-pad prodejna__inner">
        <div class="prodejna__box">
          <img class="img-cover prodejna__img" src="<?= img('prodejna.img1') ?>" alt="<?= alt('prodejna.img1') ?>" decoding="async" loading="lazy">
        </div>
        <div class="prodejna__stack-3">
          <div class="prodejna__stack">
            <span class="eyebrow prodejna__eyebrow-2"><?= t('prodejna.t1') ?></span>
            <span class="rule prodejna__rule" aria-hidden="true"></span>
            <h2 class="serif prodejna__heading" id="h-prodejna"><?= t('prodejna.t2') ?></h2>
            <p class="text prodejna__text-2"><?= t('prodejna.t3') ?></p>
          </div>
          <dl class="prodejna__facts">
            <div class="prodejna__stack-2">
              <dt class="eyebrow prodejna__eyebrow"><?= t('prodejna.t4') ?></dt>
              <dd class="serif prodejna__value-2"><?= t('prodejna.t5') ?></dd>
            </div>
            <div class="prodejna__stack-2">
              <dt class="eyebrow prodejna__eyebrow"><?= t('prodejna.t6') ?></dt>
              <dd class="prodejna__value"><?= t('prodejna.t7') ?></dd>
            </div>
          </dl>
          <?php if (t('prodejna.t8') !== ''): ?><p class="prodejna__text"><?= t('prodejna.t8') ?></p><?php endif; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('e-shop')): ?>
    <section class="e-shop" data-screen-label="E-shop" aria-labelledby="h-eshop">
      <div class="container e-shop__inner">
        <div class="e-shop__stack">
          <p class="eyebrow e-shop__eyebrow" id="h-eshop"><?= t('e-shop.t1') ?></p>
          <p class="serif e-shop__text"><?= t('e-shop.t2') ?></p>
        </div>
        <a class="btn-primary e-shop__btn" href="https://century2000-cz.webnode.cz" target="_blank" rel="noopener"><?= t('e-shop.t3') ?></a>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('poptavka')): ?>
    <section class="service-poptavka" data-screen-label="Poptávka">
      <div class="container section-pad">
        <div class="inquiry" data-c="PoptavkovyFormular" data-p-heading="Hledáte konkrétní látku nebo větší množství?" data-p-service="Látky a metráž" data-p-placeholder="Např. béžový blackout, cca 30 m, nebo vzorkovník dekoračních látek…" id="poptavka">
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
          <option>Matracové chrániče a potahy</option>
          <option selected>Látky a metráž</option>
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
      <textarea class="field inquiry__textarea" rows="5" placeholder="Např. béžový blackout, cca 30 m, nebo vzorkovník dekoračních látek…" aria-invalid="false" name="message"></textarea>
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
          <div class="service-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/bytovy-textil-na-miru/">
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
          <div class="service-souvisejici-sluzby__box"><div class="service-card" data-c="KartaSluzby"><a class="service-card__link" href="/strojni-prosivani/">
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
