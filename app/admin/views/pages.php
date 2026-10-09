<section class="adm-stack-lg">
  <div>
    <h1 class="adm-h1">Stránky webu</h1>
    <p class="adm-muted">Vyberte stránku. Upravíte texty, vyměníte obrázky nebo skryjete celou sekci.</p>
  </div>
  <?php foreach (['main' => 'Hlavní stránky', 'articles' => 'Články', 'references' => 'Reference (jednotlivé realizace)', 'other' => 'Ostatní stránky'] as $grp => $heading):
    $in = fn($doc) => $grp === 'main' ? $doc['main'] : ($grp === 'other' ? (!$doc['main'] && $doc['group'] === '') : (!$doc['main'] && $doc['group'] === $grp)); ?>
  <h2 class="adm-h2"><?= e($heading) ?></h2>
  <?php if (in_array($grp, ['articles', 'references'], true)): ?>
  <form class="adm-newform" method="post" action="<?= e(admin_url('new')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="type" value="<?= $grp === 'articles' ? 'article' : 'reference' ?>">
    <input type="text" name="title" placeholder="<?= $grp === 'articles' ? 'Název nového článku' : 'Název nové realizace' ?>" required maxlength="120" aria-label="Název">
    <button type="submit" class="adm-btn"><?= $grp === 'articles' ? 'Přidat článek' : 'Přidat realizaci' ?></button>
  </form>
  <?php endif; ?>
  <ul class="adm-list">
    <?php foreach ($docs as $name => $doc): if (!$in($doc)) continue; ?>
      <li class="adm-list__item">
        <a class="adm-list__main" href="<?= e(admin_url('edit', ['page' => $name])) ?>">
          <span class="adm-list__title"><?= e($doc['label']) ?></span>
          <span class="adm-muted"><?= $doc['path'] ? e($doc['path']) : 'společný obsah' ?> · <?= (int) $doc['sections'] ?> <?= $doc['sections'] < 5 ? 'sekce' : 'sekcí' ?></span>
        </a>
        <?php if ($doc['path']): ?>
          <a class="adm-link" href="<?= e(url($doc['path'])) ?>" target="_blank" rel="noopener">Zobrazit ↗</a>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
  <?php endforeach; ?>
</section>
