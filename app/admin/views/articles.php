<?php /** @var array $docs */ ?>
<section class="adm-stack-lg">
  <div class="adm-head-row">
    <div>
      <h1 class="adm-h1">Články</h1>
      <p class="adm-muted">Nový článek je nejdřív skrytý. Až ho dopíšete, zapněte v něm „Zobrazit článek na webu“.</p>
    </div>
  </div>
  <form class="adm-newform" id="novy" method="post" action="<?= e(admin_url('new')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="type" value="article">
    <input type="text" name="title" placeholder="Název nového článku" required maxlength="120" aria-label="Název nového článku">
    <button type="submit" class="adm-btn">+ Napsat článek</button>
  </form>
  <ul class="adm-list">
    <?php foreach ($docs as $name => $doc): ?>
      <li class="adm-list__item">
        <a class="adm-list__main" href="<?= e(admin_url('edit', ['page' => $name])) ?>">
          <span class="adm-list__title"><?= e($doc['label']) ?></span>
          <span class="adm-muted"><?= $doc['date'] ? e(cs_date($doc['date'])) . ' · ' : '' ?><?= e($doc['path']) ?></span>
        </a>
        <span class="adm-chip<?= $doc['hidden'] ? ' adm-chip--off' : '' ?>"><?= $doc['hidden'] ? 'Skrytý' : 'Na webu' ?></span>
        <?php if (!$doc['hidden']): ?><a class="adm-link" href="<?= e(url($doc['path'])) ?>" target="_blank" rel="noopener">Zobrazit ↗</a><?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
