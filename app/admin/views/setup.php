<section class="adm-card adm-narrow">
  <h1 class="adm-h1">Administrace není nastavená</h1>
  <p>Chybí heslo správce. Na počítači s projektem spusťte v terminálu:</p>
  <pre class="adm-code">php tools/set-password.php</pre>
  <p>Příkaz vytvoří soubor <code>config.php</code> s heslem. <?php if (HOSTING_BUILD): ?>Na hosting ho nahrajte do složky <code>web-data/</code> vedle <code>public_html</code>.<?php else: ?>Na hosting ho nahrajte vedle složky <code>app/</code>.<?php endif; ?></p>
</section>
