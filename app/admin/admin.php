<?php
/*
 * Administration (/admin/): login, list of pages, content editor, history of versions.
 * Pages are edited as sections of fields defined in content/*.json:
 *   text  – plain text,  rich – text with bold/italic/links,  image – upload + alt text
 * and every hideable section has a "show on the web" switch.
 * Articles (and pages with options.blocks) are built from blocks (blok-N, foto-N, tip-N) that can be added,
 * moved and removed. References have a logo, an order and a "show on the home page" switch.
 * Catalogues (PDF) are uploaded on their own screen, the admin password can be changed in Settings.
 */
declare(strict_types=1);

const ADMIN_IDLE = 4 * 3600;
const IMAGE_MAX_UPLOAD = 20 * 1024 * 1024;
const IMAGE_MAX_SIDE = 2400;
const PDF_MAX_UPLOAD = 40 * 1024 * 1024;
const CATALOG_DIR = '/downloads/vzorkovniky';

function admin_handle(): void
{
    header('X-Frame-Options: DENY');
    header('X-Robots-Tag: noindex, nofollow');
    header('Cache-Control: no-store');
    admin_session_start();

    $action = (string) ($_GET['a'] ?? 'dashboard');
    if (!admin_configured()) {
        admin_view('setup', ['title' => 'Administrace není nastavená', 'nav' => null]);
        return;
    }
    if ($action === 'login') {
        admin_login();
        return;
    }
    if (!admin_logged_in()) {
        redirect(admin_url('login'));
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        csrf_check();
    }
    match ($action) {
        'logout' => admin_logout(),
        'edit' => admin_edit(),
        'save' => admin_save(),
        'history' => admin_history(),
        'restore' => admin_restore(),
        'new' => admin_new(),
        'delete' => admin_delete(),
        'pages' => admin_pages(),
        'articles' => admin_articles(),
        'refs' => admin_refs(),
        'ref-update' => admin_ref_update(),
        'catalogs' => admin_catalogs(),
        'catalog-upload' => admin_catalog_upload(),
        'catalog-save' => admin_catalog_save(),
        'settings' => admin_settings(),
        'password' => admin_password(),
        default => admin_dashboard(),
    };
}

// ---------------------------------------------------------------- session, auth, CSRF

function admin_session_start(): void
{
    $https = ($_SERVER['HTTPS'] ?? '') !== '' && $_SERVER['HTTPS'] !== 'off';
    session_name('c2000admin');
    session_set_cookie_params(['path' => url('/admin/'), 'httponly' => true, 'samesite' => 'Strict', 'secure' => $https]);
    session_start();
    if (isset($_SESSION['seen']) && time() - $_SESSION['seen'] > ADMIN_IDLE) {
        $_SESSION = [];
        session_regenerate_id(true);
    }
    $_SESSION['seen'] = time();
}

/** Password changed in the admin (content/.runtime/admin.json) wins over the one in config.php. */
function admin_password_hash(): string
{
    $file = RUNTIME_DIR . '/admin.json';
    $data = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
    return (string) ($data['password_hash'] ?? config('admin.password_hash'));
}

function admin_configured(): bool
{
    return admin_password_hash() !== '';
}

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin']);
}

function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    if (!hash_equals(csrf_token(), (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(400);
        exit('Neplatný požadavek. Obnovte stránku a zkuste to znovu.');
    }
}

function admin_url(string $action = 'dashboard', array $params = []): string
{
    return url('/admin/') . '?' . http_build_query(['a' => $action] + $params);
}

function flash(?string $message = null, string $type = 'ok'): ?array
{
    if ($message !== null) {
        $_SESSION['flash'] = [$type, $message];
        return null;
    }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function admin_login(): void
{
    $error = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        csrf_check();
        if (!rate_limit('login', 5, 900, false)) {
            $error = 'Příliš mnoho neúspěšných pokusů. Zkuste to znovu za 15 minut.';
        } elseif (hash_equals((string) config('admin.user'), (string) ($_POST['user'] ?? ''))
            && password_verify((string) ($_POST['password'] ?? ''), admin_password_hash())) {
            rate_limit_reset('login');
            session_regenerate_id(true);
            $_SESSION['admin'] = true;
            unset($_SESSION['csrf']);
            redirect(admin_url());
        } else {
            rate_limit('login', 5, 900);
            $error = 'Nesprávné jméno nebo heslo.';
        }
    }
    admin_view('login', ['title' => 'Přihlášení', 'nav' => null, 'error' => $error]);
}

function admin_logout(): void
{
    $_SESSION = [];
    session_regenerate_id(true);
    redirect(admin_url('login'));
}

// ---------------------------------------------------------------- pages

/** Order of pages in the admin (menu order first, then system pages). */
const ADMIN_ORDER = ['index', 'bytovy-textil-na-miru', 'hotelovy-textil', 'strojni-prosivani', 'matracove-chranice-a-potahy',
    'latky-a-metraz', 'reference', 'o-nas', 'kariera', 'kontakt', 'global'];

/** Editable documents in admin order: name => {label, path|null, sections, main}. */
function admin_documents(): array
{
    $docs = [];
    foreach (content_pages() as $name => $page) {
        if (!empty($page['editable'])) {
            $docs[(string) $name] = ['label' => $page['name'], 'path' => $page['path'], 'sections' => count($page['sections']),
                'group' => match ($page['options']['type'] ?? '') { 'article' => 'articles', 'reference' => 'references', default => '' },
                'hidden' => !empty($page['options']['hidden']), 'date' => (string) ($page['options']['date'] ?? ''),
                'mtime' => (int) filemtime(content_file((string) $name))];
        }
    }
    $docs['global'] = ['label' => 'Patička a kontakty (na všech stránkách)', 'path' => null, 'sections' => 1, 'group' => '',
                       'hidden' => false, 'date' => '', 'mtime' => (int) filemtime(content_file('global'))];
    $rank = array_flip(ADMIN_ORDER);
    uksort($docs, fn($a, $b) => [$rank[$a] ?? 99, $a] <=> [$rank[$b] ?? 99, $b]);
    foreach ($docs as $name => &$doc) {
        $doc['main'] = isset($rank[$name]);
    }
    return $docs;
}

function admin_document(string $name): array
{
    $docs = admin_documents();
    if (!isset($docs[$name])) {
        http_response_code(404);
        exit('Stránka nenalezena.');
    }
    return [$docs[$name], content_load($name)];
}

/** Slug from a Czech title: "Látky na ubrusy!" → "latky-na-ubrusy". */
function slugify(string $title): string
{
    $s = mb_strtolower($title);
    $s = strtr($s, ['á' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e', 'í' => 'i', 'ň' => 'n', 'ó' => 'o',
                    'ř' => 'r', 'š' => 's', 'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ý' => 'y', 'ž' => 'z']);
    return mb_substr(trim(preg_replace('/[^a-z0-9]+/', '-', $s) ?? '', '-'), 0, 70);
}

/** Create a new article or reference from a skeleton and open it in the editor. */
function admin_new(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect(admin_url());
    }
    $type = (string) ($_POST['type'] ?? '');
    $title = clean_text((string) ($_POST['title'] ?? ''), 120);
    $slug = slugify($title);
    if (!in_array($type, ['article', 'reference'], true) || $slug === '') {
        flash('Zadejte název (písmena a číslice).', 'error');
        redirect(admin_url());
    }
    $isArticle = $type === 'article';
    $prefix = $isArticle ? 'clanek-' : 'realizace-';
    $dir = $isArticle ? '/clanky/' : '/reference/';
    if (is_file(content_file($prefix . $slug)) || page_by_path($dir . $slug . '/') !== null) {
        flash('Stránka s takovým názvem už existuje.', 'error');
        redirect(admin_url());
    }
    $f = fn(string $k, string $type, string $label, $value) => ['key' => $k, 'type' => $type, 'label' => $label, 'value' => $value];
    $img = ['src' => '/assets/fotky/textura-prosev.webp', 'alt' => ''];
    $today = date('Y-m-d');
    if ($isArticle) {
        $sections = [
            ['key' => 'hlavicka', 'label' => 'Hlavička článku', 'hideable' => false, 'visible' => true, 'fields' => [
                $f('t1', 'text', 'Nadpis (H1)', $title), $f('t2', 'text', 'Perex', ''), $f('img1', 'image', 'Hlavní obrázek', $img)]],
        ];
        $sections[] = block_section('blok', 1);
        $sections[] = ['key' => 'souvisejici-sluzba', 'label' => 'Související služba a výzva', 'hideable' => true, 'visible' => true, 'fields' => [
            $f('t1', 'text', 'Štítek', 'Související služba'), $f('t2', 'text', 'Nadpis', 'Bytový textil na míru'),
            $f('t3', 'text', 'Text', 'Závěsy, záclony, rolety, japonské stěny a přehozy šité podle vašich rozměrů.'),
            $f('t4', 'text', 'Odkaz (adresa)', '/bytovy-textil-na-miru/'), $f('t5', 'text', 'Odkaz (text)', 'Bytový textil →')]];
        $page = ['path' => "/clanky/$slug/", 'name' => $title, 'editable' => true, 'meta' => ['title' => mb_substr($title, 0, 45) . ' | Century 2000', 'description' => ''],
            'options' => ['type' => 'article', 'template' => 'clanek', 'date' => $today, 'modified' => $today, 'hidden' => true, 'image' => $img['src'], 'css' => ['obsah']], 'sections' => $sections];
    } else {
        $page = ['path' => "/reference/$slug/", 'name' => $title, 'editable' => true, 'meta' => ['title' => mb_substr($title, 0, 40) . ': reference | Century 2000', 'description' => ''],
            'options' => ['type' => 'reference', 'template' => 'realizace', 'order' => admin_next_ref_order(), 'featured' => false, 'hidden' => true, 'image' => $img['src'], 'css' => ['obsah']],
            'sections' => [
                ['key' => 'hlavicka', 'label' => 'Hlavička', 'hideable' => false, 'visible' => true, 'fields' => [
                    $f('t1', 'text', 'Název (H1)', $title), $f('t2', 'text', 'Místo', ''), $f('img1', 'image', 'Hlavní fotografie', $img)]],
                ['key' => 'logo', 'label' => 'Logo hotelu', 'hideable' => false, 'visible' => true, 'fields' => [
                    $f('img1', 'image', 'Logo', ['src' => '', 'alt' => '']) + ['optional' => true,
                        'help' => 'Nejlépe PNG s průhledným pozadím. Na webu se zobrazí šedě, barevně po najetí myší. Bez loga se ukáže název hotelu.']]],
                ['key' => 'popis', 'label' => 'Popis realizace', 'hideable' => false, 'visible' => true, 'fields' => [
                    $f('t1', 'text', 'Co jsme šili (položky oddělte čárkou)', ''), $f('t2', 'text', 'Popis', ''), $f('t3', 'text', 'Poznámka o spolupráci', '')]],
                ['key' => 'galerie', 'label' => 'Fotogalerie', 'hideable' => true, 'visible' => true, 'fields' => array_map(
                    fn($n) => $f("img$n", 'image', "Fotografie $n", $img), range(1, 4))],
            ]];
    }
    content_save($prefix . $slug, $page);
    flash('Stránka je vytvořená a zatím skrytá. Doplňte texty a obrázky, pak nahoře zapněte „Zobrazit na webu“.');
    redirect(admin_url('edit', ['page' => $prefix . $slug]));
}

function admin_dashboard(): void
{
    $docs = admin_documents();
    uasort($docs, fn($a, $b) => $b['mtime'] <=> $a['mtime']);
    $backups = 0;
    $lastBackup = 0;
    foreach (glob(CONTENT_DIR . '/backups/*/*.json') ?: [] as $f) {
        $backups++;
        $lastBackup = max($lastBackup, (int) filemtime($f));
    }
    admin_view('dashboard', ['title' => 'Přehled', 'nav' => 'dashboard', 'recent' => array_slice($docs, 0, 6, true),
        'backups' => $backups, 'lastBackup' => $lastBackup]);
}

function admin_pages(): void
{
    admin_view('pages', ['title' => 'Stránky webu', 'nav' => 'pages', 'docs' => admin_documents()]);
}

function admin_articles(): void
{
    $docs = array_filter(admin_documents(), fn($d) => $d['group'] === 'articles');
    uasort($docs, fn($a, $b) => [$b['date'], $a['label']] <=> [$a['date'], $b['label']]);
    admin_view('articles', ['title' => 'Články', 'nav' => 'articles', 'docs' => $docs]);
}

/** Reference pages in web order: name => page. Hidden ones included (they keep their place). */
function admin_ref_pages(): array
{
    $list = [];
    foreach (content_pages() as $name => $p) {
        if (($p['options']['type'] ?? '') === 'reference') {
            $list[(string) $name] = $p;
        }
    }
    uasort($list, fn($a, $b) => [$a['options']['order'] ?? 99, $a['name']] <=> [$b['options']['order'] ?? 99, $b['name']]);
    return $list;
}

function admin_next_ref_order(): int
{
    $max = 0;
    foreach (admin_ref_pages() as $p) {
        $max = max($max, (int) ($p['options']['order'] ?? 0));
    }
    return $max + 1;
}

function admin_refs(): void
{
    admin_view('refs', ['title' => 'Reference', 'nav' => 'refs', 'refs' => admin_ref_pages()]);
}

/** Reference list actions: move up/down, home page switch. Saves only "options", not the texts. */
function admin_ref_update(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect(admin_url('refs'));
    }
    $refs = admin_ref_pages();
    $names = array_keys($refs);
    $name = (string) ($_POST['page'] ?? '');
    $op = (string) ($_POST['op'] ?? '');
    if (!isset($refs[$name])) {
        redirect(admin_url('refs'));
    }
    if ($op === 'up' || $op === 'down') {
        $i = array_search($name, $names, true);
        $j = $op === 'up' ? $i - 1 : $i + 1;
        if ($j >= 0 && $j < count($names)) {
            [$names[$i], $names[$j]] = [$names[$j], $names[$i]];
        }
        foreach ($names as $pos => $n) {
            if ((int) ($refs[$n]['options']['order'] ?? 0) !== $pos + 1) {
                $refs[$n]['options']['order'] = $pos + 1;
                content_save($n, $refs[$n]);
            }
        }
        flash('Pořadí je uložené.');
    } elseif ($op === 'featured') {
        $refs[$name]['options']['featured'] = ($_POST['value'] ?? '') === '1';
        content_save($name, $refs[$name]);
        flash($refs[$name]['options']['featured'] ? "{$refs[$name]['name']}: zobrazí se na úvodní stránce." : "{$refs[$name]['name']}: na úvodní stránce se nezobrazí.");
    }
    redirect(admin_url('refs') . '#ref-' . $name);
}

/** Delete an article or a reference. The file goes to content/backups/_smazane/, nothing is lost for good. */
function admin_delete(): void
{
    $name = (string) ($_POST['page'] ?? '');
    $page = $_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('/^(clanek|realizace)-[a-z0-9-]+$/', $name) ? content_load($name) : null;
    if (!$page || !in_array($page['options']['type'] ?? '', ['article', 'reference'], true)) {
        redirect(admin_url());
    }
    $dir = CONTENT_DIR . '/backups/_smazane';
    ensure_dir($dir);
    rename(content_file($name), $dir . '/' . $name . '_' . date('Y-m-d_H-i-s') . '.json');
    flash("„{$page['name']}“ je smazáno. (Kopie zůstala v záloze na serveru, vývojář ji umí vrátit.)");
    redirect(admin_url($page['options']['type'] === 'article' ? 'articles' : 'refs'));
}

/** Does this page consist of addable/movable blocks (blok-N, foto-N, tip-N)? */
function admin_has_blocks(array $data): bool
{
    return ($data['options']['type'] ?? '') === 'article' || !empty($data['options']['blocks']);
}

const BLOCK_TYPES = ['blok' => 'Odstavec', 'foto' => 'Obrázek s popiskem', 'tip' => 'Rámeček „Dobré vědět“'];

function block_section(string $type, int $n): array
{
    $f = fn(string $k, string $t, string $label, $value, array $extra = []) => ['key' => $k, 'type' => $t, 'label' => $label, 'value' => $value] + $extra;
    return match ($type) {
        'foto' => ['key' => "foto-$n", 'label' => 'Obrázek s popiskem', 'hideable' => true, 'visible' => true, 'fields' => [
            $f('img1', 'image', 'Obrázek', ['src' => '/assets/fotky/textura-prosev.webp', 'alt' => '']),
            $f('t1', 'text', 'Popisek pod obrázkem', '')]],
        'tip' => ['key' => "tip-$n", 'label' => 'Rámeček: Dobré vědět', 'hideable' => true, 'visible' => true, 'fields' => [
            $f('t1', 'text', 'Nadpis rámečku', 'Dobré vědět'), $f('r1', 'rich', 'Text', '')]],
        default => ['key' => "blok-$n", 'label' => 'Odstavec', 'hideable' => true, 'visible' => true, 'fields' => [
            $f('t1', 'text', 'Mezititulek (H2)', ''),
            $f('r1', 'rich', 'Text', '', ['help' => 'Nový odstavec = dvakrát Enter.']),
            $f('t2', 'text', 'Odrážky', '', ['multiline' => true, 'help' => 'Každá odrážka na nový řádek. Prázdné = bez odrážek.'])]],
    };
}

/** Block operation from the editor: "add:foto", "add:blok:foto-2" (after a block), "up:blok-2", "down:…", "del:…". */
function apply_block_op(array &$data, string $op): ?string
{
    $parts = explode(':', $op);
    $keys = array_column($data['sections'], 'key');
    if ($parts[0] === 'add' && isset(BLOCK_TYPES[$parts[1] ?? ''])) {
        $type = $parts[1];
        $n = 1;
        while (in_array("$type-$n", $keys, true)) {
            $n++;
        }
        $new = block_section($type, $n);
        $after = array_search($parts[2] ?? '', $keys, true);
        $pos = $after === false ? count($data['sections']) : $after + 1;
        // a new block at the end goes before the closing "related service" box
        if ($after === false && end($keys) === 'souvisejici-sluzba') {
            $pos--;
        }
        array_splice($data['sections'], $pos, 0, [$new]);
        return $new['key'];
    }
    $i = array_search($parts[1] ?? '', $keys, true);
    if ($i === false || !preg_match('/^(blok|foto|tip)-/', $keys[$i])) {
        return null;
    }
    $isBlock = fn($k) => (bool) preg_match('/^(blok|foto|tip)-/', $k);
    if ($parts[0] === 'del') {
        array_splice($data['sections'], $i, 1);
        return null;
    }
    $j = $parts[0] === 'up' ? $i - 1 : ($parts[0] === 'down' ? $i + 1 : -1);
    if ($j >= 0 && $j < count($keys) && $isBlock($keys[$j])) {
        [$data['sections'][$i], $data['sections'][$j]] = [$data['sections'][$j], $data['sections'][$i]];
    }
    return $keys[$i];
}

/** Admin-editable options by page type: [key => [label, type, help]]. */
function admin_options(array $data): array
{
    return match ($data['options']['type'] ?? '') {
        'article' => [
            'hidden' => ['Zobrazit článek na webu', 'visible', 'Vypnuto = článek je rozepsaný, návštěvníci ho neuvidí.'],
            'date' => ['Datum článku', 'date', 'Podle data se řadí výpis článků (nejnovější první).'],
            'service' => ['Nabízet u služeb', 'services', 'Na stránkách vybraných služeb se článek zobrazí jako doporučené čtení.'],
        ],
        'reference' => [
            'hidden' => ['Zobrazit referenci na webu', 'visible', 'Vypnuto = reference je rozpracovaná, návštěvníci ji neuvidí.'],
            'featured' => ['Zobrazit na úvodní stránce', 'bool', 'Logo (nebo název) hotelu se ukáže v pruhu pod úvodní fotkou a na stránce Hotelový textil.'],
        ],
        default => [],
    };
}

/** Service pages offered in the article "related services" checklist. */
const SERVICE_PAGES = ['/bytovy-textil-na-miru/' => 'Bytový textil na míru', '/hotelovy-textil/' => 'Hotelový textil',
    '/strojni-prosivani/' => 'Strojní prošívání', '/matracove-chranice-a-potahy/' => 'Matracové chrániče a potahy', '/latky-a-metraz/' => 'Látky a metráž'];

function admin_edit(): void
{
    $name = (string) ($_GET['page'] ?? '');
    [$doc, $data] = admin_document($name);
    $nav = match (true) { $name === 'index' => 'index', $name === 'global' => 'global', $doc['group'] === 'articles' => 'articles',
                          $doc['group'] === 'references' => 'refs', default => 'pages' };
    admin_view('edit', ['title' => $doc['label'], 'nav' => $nav, 'name' => $name, 'doc' => $doc, 'data' => $data,
                        'version' => (string) filemtime(content_file($name)), 'options' => admin_options($data),
                        'blocks' => admin_has_blocks($data), 'open' => (string) ($_GET['open'] ?? '')]);
}

function admin_save(): void
{
    $name = (string) ($_GET['page'] ?? '');
    [, $data] = admin_document($name);

    if ((string) ($_POST['version'] ?? '') !== (string) filemtime(content_file($name))) {
        flash('Stránku mezitím upravil někdo jiný (nebo jiné okno). Vaše změny nebyly uloženy – načetla se aktuální verze.', 'error');
        redirect(admin_url('edit', ['page' => $name]));
    }

    if (isset($data['meta'])) {
        $data['meta']['title'] = clean_text((string) ($_POST['meta']['title'] ?? $data['meta']['title']), 200);
        $data['meta']['description'] = clean_text((string) ($_POST['meta']['description'] ?? $data['meta']['description']), 400);
    }
    foreach (admin_options($data) as $key => [, $type]) {
        $in = $_POST['opt'][$key] ?? null;
        if ($type === 'visible' && $in !== null) {
            $data['options']['hidden'] = $in !== '1';
        } elseif ($type === 'bool' && $in !== null) {
            $data['options'][$key] = $in === '1';
        } elseif ($type === 'date' && is_string($in) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $in)) {
            $data['options'][$key] = $in;
        } elseif ($type === 'services' && isset($_POST['opt_present'][$key])) {
            $data['options'][$key] = array_values(array_intersect(array_keys(SERVICE_PAGES), (array) ($in ?? [])));
        }
    }
    if (($data['options']['type'] ?? '') === 'article') {
        $data['options']['modified'] = date('Y-m-d');
    }

    $errors = [];
    foreach ($data['sections'] as &$section) {
        $sk = $section['key'];
        if (!empty($section['hideable']) && isset($_POST['visible'][$sk])) {
            $section['visible'] = $_POST['visible'][$sk] === '1';
        }
        foreach ($section['fields'] as &$field) {
            $fk = $field['key'];
            switch ($field['type']) {
                case 'text':
                    if (isset($_POST['f'][$sk][$fk])) {
                        $field['value'] = clean_text((string) $_POST['f'][$sk][$fk], 3000);
                    }
                    break;
                case 'rich':
                    if (isset($_POST['f'][$sk][$fk])) {
                        $field['value'] = sanitize_rich((string) $_POST['f'][$sk][$fk]);
                    }
                    break;
                case 'image':
                    if (isset($_POST['alt'][$sk][$fk])) {
                        $field['value']['alt'] = clean_text((string) $_POST['alt'][$sk][$fk], 300);
                    }
                    if (!empty($field['optional']) && !empty($_POST['remove'][$sk][$fk])) {
                        $field['value']['src'] = '';
                    }
                    $upload = uploaded_file('img', $sk, $fk);
                    if ($upload) {
                        try {
                            $field['value']['src'] = save_uploaded_image($upload);
                        } catch (RuntimeException $ex) {
                            $errors[] = "{$section['label']} – {$field['label']}: " . $ex->getMessage();
                        }
                    }
                    break;
            }
        }
        unset($field);
    }
    unset($section);
    // the article card and Open Graph use options.image: keep it in sync with the main picture
    if (in_array($data['options']['type'] ?? '', ['article', 'reference'], true)) {
        $main = page_field($data, 'hlavicka', 'img1')['value']['src'] ?? '';
        if ($main !== '') {
            $data['options']['image'] = $main;
        }
    }

    $op = (string) ($_POST['op'] ?? '');
    $open = null;
    if ($op !== '' && admin_has_blocks($data)) {
        $open = apply_block_op($data, $op);
    }

    content_save($name, $data);
    if ($errors) {
        flash("Uloženo, ale některé obrázky se nepodařilo nahrát:\n" . implode("\n", $errors), 'error');
    } elseif (str_starts_with($op, 'add:')) {
        flash('Blok je přidaný, vyplňte ho a uložte.');
    } elseif (str_starts_with($op, 'del:')) {
        flash('Blok je odstraněný. (Předchozí verze je v Historii verzí.)');
    } elseif ($op !== '') {
        flash('Pořadí bloků je uložené.');
    } else {
        flash('Změny jsou uložené a na webu.');
    }
    redirect(admin_url('edit', ['page' => $name] + ($open ? ['open' => $open] : [])) . ($open ? '#s-' . $open : ''));
}

// ---------------------------------------------------------------- catalogues (PDF)

function admin_catalogs(): void
{
    $page = content_load('vzorkovniky');
    admin_view('catalogs', ['title' => 'Vzorkovníky', 'nav' => 'catalogs', 'files' => $page['options']['files'] ?? [],
                            'version' => (string) filemtime(content_file('vzorkovniky'))]);
}

function format_size(int $bytes): string
{
    return $bytes >= 1048576 ? number_format($bytes / 1048576, 1, ',', ' ') . ' MB' : max(1, (int) round($bytes / 1024)) . ' kB';
}

function admin_catalog_upload(): void
{
    $f = $_FILES['pdf'] ?? null;
    $title = clean_text((string) ($_POST['title'] ?? ''), 120);
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$f || $f['error'] === UPLOAD_ERR_NO_FILE) {
        flash('Vyberte soubor PDF.', 'error');
        redirect(admin_url('catalogs'));
    }
    if (in_array($f['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true) || $f['size'] > PDF_MAX_UPLOAD) {
        flash('Soubor je příliš velký (max. 40 MB).', 'error');
        redirect(admin_url('catalogs'));
    }
    if ($f['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name']) || file_get_contents($f['tmp_name'], false, null, 0, 5) !== '%PDF-') {
        flash('Nahrát jde jen soubor PDF.', 'error');
        redirect(admin_url('catalogs'));
    }
    $base = slugify(pathinfo((string) $f['name'], PATHINFO_FILENAME)) ?: 'vzorkovnik';
    $rel = CATALOG_DIR . '/' . $base . '.pdf';
    for ($n = 2; is_file(PUBLIC_DIR . $rel); $n++) {
        $rel = CATALOG_DIR . "/$base-$n.pdf";
    }
    ensure_dir(PUBLIC_DIR . CATALOG_DIR);
    if (!move_uploaded_file($f['tmp_name'], PUBLIC_DIR . $rel)) {
        flash('Soubor se nepodařilo uložit, zkuste to znovu.', 'error');
        redirect(admin_url('catalogs'));
    }
    $page = content_load('vzorkovniky');
    $page['options']['files'][] = ['file' => $rel, 'title' => $title !== '' ? $title : pathinfo((string) $f['name'], PATHINFO_FILENAME),
                                   'size' => format_size((int) filesize(PUBLIC_DIR . $rel))];
    content_save('vzorkovniky', $page);
    flash('Vzorkovník je nahraný a na webu.');
    redirect(admin_url('catalogs'));
}

/** Rename, show/hide, reorder, delete catalogues. The list is rebuilt from the form in its order. */
function admin_catalog_save(): void
{
    $page = content_load('vzorkovniky');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || (string) ($_POST['version'] ?? '') !== (string) filemtime(content_file('vzorkovniky'))) {
        flash('Seznam mezitím změnil někdo jiný. Načetla se aktuální verze, zkuste to znovu.', 'error');
        redirect(admin_url('catalogs'));
    }
    $files = $page['options']['files'] ?? [];
    $byFile = array_column($files, null, 'file');
    $out = [];
    $deleted = [];
    foreach ((array) ($_POST['files'] ?? []) as $row) {
        $file = (string) ($row['file'] ?? '');
        if (!isset($byFile[$file])) {
            continue;
        }
        if (!empty($row['delete'])) {
            $deleted[] = $file;
            continue;
        }
        $out[] = ['file' => $file, 'title' => clean_text((string) ($row['title'] ?? ''), 120) ?: $byFile[$file]['title'],
                  'size' => $byFile[$file]['size']] + (empty($row['show']) ? ['hidden' => true] : []);
    }
    $op = (string) ($_POST['op'] ?? '');
    if (preg_match('/^(up|down):(\d+)$/', $op, $m)) {
        $i = (int) $m[2];
        $j = $m[1] === 'up' ? $i - 1 : $i + 1;
        if (isset($out[$i], $out[$j])) {
            [$out[$i], $out[$j]] = [$out[$j], $out[$i]];
        }
    }
    $page['options']['files'] = $out;
    content_save('vzorkovniky', $page);
    foreach ($deleted as $file) {
        if (str_starts_with($file, CATALOG_DIR . '/') && !str_contains($file, '..')) {
            $dir = CONTENT_DIR . '/backups/_smazane';
            ensure_dir($dir);
            @rename(PUBLIC_DIR . $file, $dir . '/' . basename($file));
        }
    }
    flash($deleted ? 'Uloženo. Smazané soubory: ' . count($deleted) . '.' : 'Uloženo.');
    redirect(admin_url('catalogs'));
}

// ---------------------------------------------------------------- settings

function admin_settings(): void
{
    admin_view('settings', ['title' => 'Nastavení', 'nav' => 'settings']);
}

function admin_password(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect(admin_url('settings'));
    }
    $current = (string) ($_POST['current'] ?? '');
    $new = (string) ($_POST['new'] ?? '');
    if (!password_verify($current, admin_password_hash())) {
        flash('Současné heslo není správně.', 'error');
    } elseif (mb_strlen($new) < 10) {
        flash('Nové heslo musí mít aspoň 10 znaků.', 'error');
    } elseif ($new !== (string) ($_POST['again'] ?? '')) {
        flash('Nová hesla se neshodují.', 'error');
    } else {
        write_file_atomic(RUNTIME_DIR . '/admin.json', json_encode(['password_hash' => password_hash($new, PASSWORD_DEFAULT), 'changed' => date('c')]) . "\n");
        session_regenerate_id(true);
        flash('Heslo je změněné. Příště se přihlaste novým heslem.');
    }
    redirect(admin_url('settings'));
}

function admin_history(): void
{
    $name = (string) ($_GET['page'] ?? '');
    [$doc] = admin_document($name);
    admin_view('history', ['title' => 'Historie: ' . $doc['label'], 'nav' => '', 'name' => $name, 'doc' => $doc,
                           'backups' => content_backups($name)]);
}

function admin_restore(): void
{
    $name = (string) ($_GET['page'] ?? '');
    admin_document($name);
    content_restore($name, (string) ($_POST['backup'] ?? ''));
    flash('Obnovena předchozí verze. (Verze před obnovením je uložená v historii.)');
    redirect(admin_url('edit', ['page' => $name]));
}

// ---------------------------------------------------------------- input cleaning

function clean_text(string $s, int $max): string
{
    $s = str_replace(["\r\n", "\r"], "\n", $s);
    $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $s) ?? '';
    return mb_substr(trim($s), 0, $max);
}

/**
 * Allow only simple inline formatting: bold, italic, line break, links, and the design's highlight marks.
 * Everything else is unwrapped to text.
 */
function sanitize_rich(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    $doc = new DOMDocument();
    $prev = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8"?><div id="rich-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    $root = $doc->getElementById('rich-root');
    if (!$root) {
        return e(strip_tags($html));
    }
    sanitize_node($root);
    $out = '';
    foreach (iterator_to_array($root->childNodes) as $child) {
        $out .= $doc->saveHTML($child);
    }
    $out = preg_replace('/(<br>\s*)+$/', '', trim($out)) ?? '';
    return mb_substr($out, 0, 20000);
}

function sanitize_node(DOMNode $node): void
{
    $rename = ['b' => 'strong', 'i' => 'em'];
    $allowed = ['strong' => [], 'em' => [], 'br' => [], 'a' => ['href', 'target', 'rel', 'class'], 'mark' => ['class'], 'span' => ['class']];
    $blocks = ['div', 'p', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'];

    foreach (iterator_to_array($node->childNodes) as $child) {
        if ($child instanceof DOMText) {
            continue;
        }
        if (!$child instanceof DOMElement) {
            $node->removeChild($child);
            continue;
        }
        $tag = strtolower($child->tagName);
        if (isset($rename[$tag])) {
            $new = $child->ownerDocument->createElement($rename[$tag]);
            while ($child->firstChild) {
                $new->appendChild($child->firstChild);
            }
            $node->replaceChild($new, $child);
            $child = $new;
            $tag = $rename[$tag];
        }
        if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'template'], true)) {
            $node->removeChild($child);
            continue;
        }
        sanitize_node($child);
        if (!isset($allowed[$tag])) {
            // unwrap; block elements become line breaks
            $isBlock = in_array($tag, $blocks, true);
            if ($isBlock && $child->previousSibling) {
                $node->insertBefore($child->ownerDocument->createElement('br'), $child);
            }
            while ($child->firstChild) {
                $node->insertBefore($child->firstChild, $child);
            }
            $node->removeChild($child);
            continue;
        }
        foreach (iterator_to_array($child->attributes) as $attr) {
            $an = strtolower($attr->name);
            $ok = in_array($an, $allowed[$tag], true);
            if ($ok && $an === 'href') {
                $ok = (bool) preg_match('~^(https?://|mailto:|tel:|/|#)~i', trim($attr->value));
            }
            if ($ok && $an === 'class') {
                $ok = (bool) preg_match('/^[a-z0-9_ -]+$/i', $attr->value);
            }
            if ($ok && $an === 'target') {
                $ok = $attr->value === '_blank';
            }
            if (!$ok) {
                $child->removeAttribute($attr->name);
            }
        }
        if ($tag === 'a' && $child->getAttribute('target') === '_blank') {
            $child->setAttribute('rel', 'noopener');
        }
        if (in_array($tag, ['span', 'mark'], true) && !$child->hasAttributes()) {
            while ($child->firstChild) {
                $node->insertBefore($child->firstChild, $child);
            }
            $node->removeChild($child);
        }
    }
}

// ---------------------------------------------------------------- images

/** $_FILES['img']['…'][$section][$field] → single file array, or null. */
function uploaded_file(string $input, string $section, string $field): ?array
{
    $f = $_FILES[$input] ?? null;
    if (!$f || !isset($f['error'][$section][$field]) || $f['error'][$section][$field] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    return [
        'name' => $f['name'][$section][$field], 'tmp_name' => $f['tmp_name'][$section][$field],
        'error' => $f['error'][$section][$field], 'size' => $f['size'][$section][$field],
    ];
}

/** Validate, auto-rotate, shrink and convert an uploaded photo to WebP. Returns its URL path. */
function save_uploaded_image(array $file): string
{
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > IMAGE_MAX_UPLOAD) {
        throw new RuntimeException('soubor je příliš velký (max. 20 MB).');
    }
    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException('nahrání selhalo, zkuste to znovu.');
    }
    $info = @getimagesize($file['tmp_name']);
    $type = $info[2] ?? 0;
    $img = match ($type) {
        IMAGETYPE_JPEG => @imagecreatefromjpeg($file['tmp_name']),
        IMAGETYPE_PNG => @imagecreatefrompng($file['tmp_name']),
        IMAGETYPE_WEBP => @imagecreatefromwebp($file['tmp_name']),
        IMAGETYPE_GIF => @imagecreatefromgif($file['tmp_name']),
        default => false,
    };
    if (!$img) {
        throw new RuntimeException('nepodporovaný formát. Použijte fotku ve formátu JPG, PNG nebo WebP.');
    }
    if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $orientation = (int) (@exif_read_data($file['tmp_name'])['Orientation'] ?? 1);
        $rotated = match ($orientation) { 3 => imagerotate($img, 180, 0), 6 => imagerotate($img, -90, 0), 8 => imagerotate($img, 90, 0), default => null };
        if ($rotated) {
            imagedestroy($img);
            $img = $rotated;
        }
    }
    $w = imagesx($img);
    $h = imagesy($img);
    $scale = min(1, IMAGE_MAX_SIDE / max($w, $h));
    if ($scale < 1) {
        $resized = imagecreatetruecolor((int) round($w * $scale), (int) round($h * $scale));
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized), imagesy($resized), $w, $h);
        imagedestroy($img);
        $img = $resized;
    } else {
        imagepalettetotruecolor($img);
        imagealphablending($img, false);
        imagesavealpha($img, true);
    }

    $base = mb_strtolower(pathinfo((string) $file['name'], PATHINFO_FILENAME));
    $base = strtr($base, ['á' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e', 'í' => 'i', 'ň' => 'n', 'ó' => 'o',
                          'ř' => 'r', 'š' => 's', 'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ý' => 'y', 'ž' => 'z', 'ä' => 'a', 'ö' => 'o', 'ü' => 'u']);
    $base = trim(preg_replace('/[^a-z0-9]+/', '-', $base) ?? '', '-') ?: 'foto';
    $rel = '/uploads/' . date('Y/m') . '/' . mb_substr($base, 0, 50) . '-' . bin2hex(random_bytes(3));
    ensure_dir(PUBLIC_DIR . dirname($rel . '.x'));
    if (function_exists('imagewebp') && imagewebp($img, PUBLIC_DIR . $rel . '.webp', 82)) {
        $rel .= '.webp';
    } elseif (imagejpeg($img, PUBLIC_DIR . $rel . '.jpg', 85)) {
        $rel .= '.jpg';
    } else {
        throw new RuntimeException('obrázek se nepodařilo uložit.');
    }
    imagedestroy($img);
    return $rel;
}

// ---------------------------------------------------------------- views

function admin_view(string $view, array $vars): void
{
    extract($vars);
    $flash = flash();
    include APP_DIR . '/admin/views/layout.php';
}

function admin_partial(string $view, array $vars): void
{
    extract($vars);
    include APP_DIR . "/admin/views/$view.php";
}
