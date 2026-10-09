<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('uvodni-blok')): ?>
    <section class="kontakt-hero" data-screen-label="Hero" aria-labelledby="hero-h1">
      <div class="container kontakt-hero__inner">
        <span class="rule kontakt-hero__rule" aria-hidden="true"></span>
        <h1 class="title-hero kontakt-hero__title" id="hero-h1"><?= t('uvodni-blok.t1') ?></h1>
        <p class="text kontakt-hero__text"><?= t('uvodni-blok.t2') ?></p>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('poptavka')): ?>
    <section class="kontakt-poptavka" data-screen-label="Poptávka">
      <div class="container kontakt-poptavka__inner">
        <div class="inquiry" data-c="PoptavkovyFormular" data-p-service="" data-p-placeholder="Popište, co potřebujete – rozměry, množství, termín…" data-p-aside="kontakt" id="poptavka">
  <div class="show-below-900">
    <div class="inquiry__contact-top">
      <a class="btn-primary inquiry__call" href="tel:+420603287803"><?= t('poptavka.t1') ?></a>
      <a class="inquiry__mail" href="mailto:info@century2000.cz"><?= t('poptavka.t2') ?></a>
      <dl class="inquiry__facts--top">
        <div class="inquiry__fact"><dt class="eyebrow inquiry__fact-label"><?= t('poptavka.t3') ?></dt><dd class="inquiry__fact-value--dark"><?= t('poptavka.t4') ?></dd></div>
        <div class="inquiry__fact"><dt class="eyebrow inquiry__fact-label"><?= t('poptavka.t5') ?></dt><dd class="inquiry__fact-value--dark"><?= t('poptavka.t6') ?></dd></div>
      </dl>
    </div>
  </div>
  <form class="inquiry__form" data-on-submit="submit" data-thanks="/dekujeme/" novalidate action="/odeslat/poptavka/" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?= form_token() ?>">
    <div class="form-hp" aria-hidden="true"><label>Nevyplňujte <input type="text" name="web" tabindex="-1" autocomplete="off"></label></div>
    <p class="form-alert" id="formular-chyba" role="alert" hidden></p>
    <div class="inquiry__intro">
      <h2 class="title-section"><?= t('poptavka.t7') ?></h2>
        <p class="text inquiry__lead"><?= rich('poptavka.r1') ?></p>
    </div>
    <label class="inquiry__field">
      <span class="inquiry__field-label">O jakou službu jde?</span>
      <span class="inquiry__select-wrap">
        <select class="field inquiry__select" name="service">
          <option value="" selected>—</option>
          <option>Bytový textil</option>
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
      <textarea class="field inquiry__textarea" rows="5" placeholder="Popište, co potřebujete – rozměry, množství, termín…" aria-invalid="false" name="message"></textarea>
      <span data-if="e.message" hidden><span class="inquiry__error">Vyplňte prosím toto pole.</span></span>
    </label>
    <div class="inquiry__file">
      <span class="inquiry__field-label"><?= t('poptavka.t8') ?></span>
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
  <div class="show-from-900">
  <aside class="inquiry__aside--kontakt">
    <dl class="inquiry__facts">
      <div class="inquiry__fact-row"><dt class="eyebrow inquiry__fact-label"><?= t('poptavka.t9') ?></dt><dd class="inquiry__fact-value"><a class="serif inquiry__fact-phone" href="tel:+420603287803"><?= t('poptavka.t10') ?></a></dd></div>
      <div class="inquiry__fact-row"><dt class="eyebrow inquiry__fact-label"><?= t('poptavka.t11') ?></dt><dd class="inquiry__fact-value"><a class="inquiry__fact-email" href="mailto:info@century2000.cz"><?= t('poptavka.t2') ?></a></dd></div>
      <div class="inquiry__fact-row--hours"><dt class="eyebrow inquiry__fact-label"><?= t('poptavka.t3') ?></dt><dd class="inquiry__fact-value--dark"><?= t('poptavka.t4') ?></dd></div>
      <div class="inquiry__fact-row--last"><dt class="eyebrow inquiry__fact-label"><?= t('poptavka.t5') ?></dt><dd class="inquiry__fact-value--dark"><?= t('poptavka.t6') ?></dd></div>
    </dl>
  </aside>
  </div>
</div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('jednatel-adresa-a-fakturace')): ?>
    <section data-screen-label="Jednatel, adresa a fakturace">
      <div class="container section-pad jednatel-adresa-a-fakturace__inner">
        <div class="jednatel-adresa-a-fakturace__stack-2">
          <h2 class="title-card" id="h-jednatel"><?= t('jednatel-adresa-a-fakturace.t1') ?></h2>
          <p class="jednatel-adresa-a-fakturace__text-2"><?= t('jednatel-adresa-a-fakturace.t2') ?></p>
          <div class="jednatel-adresa-a-fakturace__stack">
            <a class="link-arrow jednatel-adresa-a-fakturace__link" href="tel:+420603287803"><?= t('jednatel-adresa-a-fakturace.t3') ?></a>
            <a class="link-arrow jednatel-adresa-a-fakturace__link" href="mailto:vobecky@century2000.cz"><?= t('jednatel-adresa-a-fakturace.t4') ?></a>
          </div>
        </div>
        <div class="jednatel-adresa-a-fakturace__stack-2">
          <h2 class="title-card" id="h-adresa"><?= t('jednatel-adresa-a-fakturace.t5') ?></h2>
          <address class="jednatel-adresa-a-fakturace__address">
            <?= rich('jednatel-adresa-a-fakturace.r1') ?>
          </address>
          <?php if (t('jednatel-adresa-a-fakturace.t6') !== ''): ?><p class="jednatel-adresa-a-fakturace__text"><?= t('jednatel-adresa-a-fakturace.t6') ?></p><?php endif; ?>
          <p class="jednatel-adresa-a-fakturace__text-3"><?= rich('jednatel-adresa-a-fakturace.r2') ?></p>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <?php if (visible('jak-nas-najit')): ?>
    <section class="jak-nas-najit" data-screen-label="Jak nás najít" aria-labelledby="h-mapa">
      <div class="container section-pad jak-nas-najit__inner">
        <div class="jak-nas-najit__stack-2">
          <div class="jak-nas-najit__stack">
          <span class="rule jak-nas-najit__rule" aria-hidden="true"></span>
          <h2 class="title-section jak-nas-najit__heading" id="h-mapa"><?= t('jak-nas-najit.t1') ?></h2>
        </div>
          <p class="text"><?= t('jak-nas-najit.t2') ?></p>
          <?php if (t('jak-nas-najit.t3') !== ''): ?><p class="jak-nas-najit__text"><?= t('jak-nas-najit.t3') ?></p><?php endif; ?>
          <a class="btn-primary jak-nas-najit__btn" href="https://mapy.cz/zakladni?q=Okru%C5%BEn%C3%AD%20600%2C%20285%2022%20Zru%C4%8D%20nad%20S%C3%A1zavou" target="_blank" rel="noopener"><?= t('jak-nas-najit.t4') ?></a>
        </div>
        <div class="jak-nas-najit__box">
          <div class="jak-nas-najit__row" role="img" aria-label="Mapa – vložíme při implementaci"><span class="jak-nas-najit__label"><?= t('jak-nas-najit.t5') ?></span></div>
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
