<?php
/* Odkazy na související články: na stránkách služeb články s touto službou, jinde nejnovější. */
$svc = $GLOBALS['page']['path'] ?? '/';
$list = articles_for(in_array($svc, SERVICE_PATHS, true) ? $svc : null, 3);
if (!$list) {
    $list = articles_for(null, 3);
}
?>
<?php if ($list): ?>
<section class="clanky-teaser" aria-labelledby="h-clanky-teaser" data-screen-label="Články">
  <div class="container section-pad clanky-teaser__inner">
    <div class="clanky-teaser__head">
      <h2 class="title-section" id="h-clanky-teaser">Z našich článků</h2>
      <a class="link-arrow" href="/clanky/">Všechny články →</a>
    </div>
    <ul class="clanky-grid">
      <?php foreach ($list as $p): $im = page_field($p, 'hlavicka', 'img1'); $perex = page_field($p, 'hlavicka', 't2'); ?>
      <li class="clanky-card"><a class="clanky-card__link" href="<?= e($p['path']) ?>">
        <?php if ($im): ?><span class="clanky-card__media"><img class="img-cover" src="<?= e(img_small($im['value']['src'])) ?>" alt="" decoding="async" loading="lazy"></span><?php endif; ?>
        <span class="clanky-card__body">
          <span class="serif clanky-card__title"><?= e($p['name']) ?></span>
          <span class="text clanky-card__perex"><?= e((string) ($perex['value'] ?? '')) ?></span>
          <span class="link-arrow">Číst článek →</span>
        </span>
      </a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php endif; ?>
