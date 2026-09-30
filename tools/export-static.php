<?php
/*
 * Export the site as static HTML (client preview on GitHub Pages, visual checks).
 *
 *   php tools/export-static.php [--demo] [--base /century2000-web] [--out site]
 *
 * Forms in the export have no server: they validate and go straight to the thank-you page.
 */
declare(strict_types=1);

define('PUBLIC_DIR', dirname(__DIR__) . '/public');
require dirname(__DIR__) . '/app/bootstrap.php';

$args = array_slice($argv, 1);
$opt = fn(string $name, $default = null) => ($i = array_search($name, $args, true)) !== false ? ($args[$i + 1] ?? $default) : $default;
$GLOBALS['config']['demo'] = in_array('--demo', $args, true);
$GLOBALS['config']['base_path'] = rtrim((string) $opt('--base', ''), '/');
$out = ROOT_DIR . '/' . trim((string) $opt('--out', 'site'), '/');

function rrmdir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $f) {
        $f->isDir() ? rmdir($f->getPathname()) : unlink($f->getPathname());
    }
    rmdir($dir);
}

function rcopy(string $from, string $to): void
{
    if (!is_dir($from)) {
        return;
    }
    ensure_dir($to);
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST) as $f) {
        $target = $to . '/' . substr($f->getPathname(), strlen($from) + 1);
        $f->isDir() ? ensure_dir($target) : copy($f->getPathname(), $target);
    }
}

rrmdir($out);
rcopy(PUBLIC_DIR . '/assets', "$out/assets");
rcopy(PUBLIC_DIR . '/uploads', "$out/uploads");

$count = 0;
foreach (content_pages() as $name => $page) {
    $html = render_page((string) $name);
    // No PHP on static hosting: drop the form endpoint and spam fields, JS redirects to the thank-you page.
    $html = preg_replace('/\saction="[^"]*"/', '', $html);
    $html = preg_replace('#\s*<input type="hidden" name="token"[^>]*>\s*<div class="form-hp".*?</div>#s', '', $html);
    $file = str_ends_with($page['path'], '.html') ? $out . $page['path'] : $out . $page['path'] . 'index.html';
    ensure_dir(dirname($file));
    file_put_contents($file, $html);
    $count++;
}
file_put_contents("$out/sitemap.xml", sitemap_xml());
file_put_contents("$out/robots.txt", robots_txt());
echo "exported $count pages -> " . basename($out) . "/\n";
