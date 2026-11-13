<section class="adm-stack-lg">
  <div>
    <h1 class="adm-h1">Stránky webu</h1>
    <p class="adm-muted">Vyberte stránku. Upravíte texty, vyměníte obrázky nebo skryjete celou sekci. Články a reference mají vlastní položky v menu vlevo.</p>
  </div>
  <?php foreach (['main' => 'Hlavní stránky', 'other' => 'Ostatní stránky'] as $grp => $heading):
    $in = fn($doc) => $grp === 'main' ? $doc['main'] : ($grp === 'other' ? (!$doc['main'] && $doc['group'] === '') : (!$doc['main'] && $doc['group'] === $grp)); ?>
  <h2 class="adm-h2"><?= e($heading) ?></h2>
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
