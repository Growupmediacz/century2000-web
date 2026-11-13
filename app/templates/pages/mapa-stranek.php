<div class="page">
  <?php partial('header'); ?>
  <main>
    <?php if (visible('mapa-stranek')): ?>
    <section data-screen-label="Mapa stránek" aria-labelledby="hero-h1">
      <div class="container mapa-stranek__inner">
        <div class="mapa-stranek__stack"><span class="rule mapa-stranek__rule" aria-hidden="true"></span><h1 class="title-hero mapa-stranek__title" id="hero-h1"><?= t('mapa-stranek.t1') ?></h1></div>
        <nav class="mapa-stranek__nav" aria-label="Mapa stránek">
          <ul class="mapa-stranek__list">
            <li class="mapa-stranek__item"><a class="serif mapa-stranek__link-2" href="/"><?= t('mapa-stranek.t2') ?></a></li>
            <li class="mapa-stranek__item-2">
              <span class="serif mapa-stranek__label"><?= t('mapa-stranek.t3') ?></span>
              <ul class="mapa-stranek__list-2">
                <li><a class="mapa-stranek__link" href="/bytovy-textil-na-miru/"><?= t('mapa-stranek.t4') ?></a></li>
                <li><a class="mapa-stranek__link" href="/hotelovy-textil/"><?= t('mapa-stranek.t5') ?></a></li>
                <li><a class="mapa-stranek__link" href="/strojni-prosivani/"><?= t('mapa-stranek.t6') ?></a></li>
                <li><a class="mapa-stranek__link" href="/matracove-chranice-a-potahy/"><?= t('mapa-stranek.t7') ?></a></li>
                <li><a class="mapa-stranek__link" href="/latky-a-metraz/"><?= t('mapa-stranek.t8') ?></a></li>
              </ul>
            </li>
            <li class="mapa-stranek__item-2">
              <a class="serif mapa-stranek__link-2" href="/reference/"><?= t('mapa-stranek.t9') ?></a>
              <ul class="mapa-stranek__list-2">
                <?php foreach (pages_of_type('reference') as $r): ?><li><a class="mapa-stranek__link" href="<?= e($r['path']) ?>"><?= e($r['name']) ?></a></li><?php endforeach; ?>
              </ul>
            </li>
            <li class="mapa-stranek__item-2">
              <a class="serif mapa-stranek__link-2" href="/clanky/">Články</a>
              <ul class="mapa-stranek__list-2">
                <?php foreach (pages_of_type('article') as $r): ?><li><a class="mapa-stranek__link" href="<?= e($r['path']) ?>"><?= e($r['name']) ?></a></li><?php endforeach; ?>
              </ul>
            </li>
            <li class="mapa-stranek__item"><a class="serif mapa-stranek__link-2" href="/vzorkovniky/">Vzorkovníky ke stažení</a></li>
            <li class="mapa-stranek__item"><a class="serif mapa-stranek__link-2" href="/o-nas/"><?= t('mapa-stranek.t10') ?></a></li>
            <li class="mapa-stranek__item"><a class="serif mapa-stranek__link-2" href="/kariera/"><?= t('mapa-stranek.t11') ?></a></li>
            <li class="mapa-stranek__item"><a class="serif mapa-stranek__link-2" href="/kontakt/"><?= t('mapa-stranek.t12') ?></a></li>
            <li class="mapa-stranek__item"><a class="serif mapa-stranek__link-2" href="/zasady-ochrany-osobnich-udaju/"><?= t('mapa-stranek.t13') ?></a></li>
            <li class="mapa-stranek__item"><a class="serif mapa-stranek__link-2" href="/cookies/"><?= t('mapa-stranek.t14') ?></a></li>
          </ul>
        </nav>
      </div>
    </section>
    <?php endif; ?>
  </main>
  <?php partial('footer'); ?>
  <div class="page__cookie-dock">
    <?php partial('cookie-bar'); ?>
  </div>
</div>
