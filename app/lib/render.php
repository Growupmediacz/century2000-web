<?php
/*
 * Page rendering. Templates (app/templates) are plain HTML with these helpers:
 *   <?= t('section.t1') ?>      plain text field (escaped)
 *   <?= rich('section.r1') ?>   text with formatting (sanitized when saved in the admin)
 *   <?= img('section.img1') ?>  image URL,  <?= alt('section.img1') ?> its alt text
 *   <?php if (visible('section')): ?> … <?php endif; ?>   section switch
 *   <?php partial('footer'); ?>
 * Links and assets use root paths (/kontakt/, /assets/…); the configured base path is added on output.
 */
declare(strict_types=1);

function t(string $ref): string
{
    $f = content_field($ref);
    return $f ? e((string) $f['value']) : '';
}

function rich(string $ref): string
{
    $f = content_field($ref);
    return $f ? (string) $f['value'] : '';
}

function img(string $ref): string
{
    $f = content_field($ref);
    return $f ? e($f['value']['src'] ?? '') : '';
}

function alt(string $ref): string
{
    $f = content_field($ref);
    return $f ? e($f['value']['alt'] ?? '') : '';
}

function visible(string $section): bool
{
    foreach ($GLOBALS['page']['sections'] ?? [] as $s) {
        if ($s['key'] === $section) {
            return !empty($s['visible']);
        }
    }
    return true;
}

function partial(string $name): void
{
    include APP_DIR . "/templates/partials/$name.php";
}

/** Render a page to a full HTML document. */
function render_page(string $name): string
{
    $page = content_load($name);
    if (!$page) {
        throw new RuntimeException("Unknown page $name");
    }
    $GLOBALS['page'] = $page;
    ob_start();
    include APP_DIR . "/templates/pages/$name.php";
    $body = trim((string) ob_get_clean());

    $html = "<!DOCTYPE html>\n<html lang=\"cs\">\n<head>\n" . seo_head($page) . "\n</head>\n<body>\n$body\n</body>\n</html>\n";
    return finalize_html($html, $page['path'], !empty($page['options']['absolute']));
}

/** aria-current on links to the current page; base path for root-relative URLs. */
function finalize_html(string $html, string $path, bool $absolute = false): string
{
    $html = preg_replace('/(<a\b[^>]*\shref="' . preg_quote($path, '/') . '")/', '$1 aria-current="page"', $html);
    $base = rtrim((string) config('base_path', ''), '/');
    if ($base !== '') {
        $html = preg_replace('#\b(href|src|action|data-thanks)="/(?!/)#', '$1="' . $base . '/', $html);
    }
    return $html;
}

/** Front controller: map the request path to a page, form handler or generated file. */
function handle_request(): void
{
    $path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
    $base = rtrim((string) config('base_path', ''), '/');
    if ($base !== '' && str_starts_with($path, $base)) {
        $path = substr($path, strlen($base)) ?: '/';
    }

    if ($path === '/sitemap.xml') {
        header('Content-Type: application/xml; charset=utf-8');
        echo sitemap_xml();
        return;
    }
    if ($path === '/robots.txt') {
        header('Content-Type: text/plain; charset=utf-8');
        echo robots_txt();
        return;
    }
    if (preg_match('#^/odeslat/(poptavka|kariera)/?$#', $path, $m)) {
        handle_form($m[1]);
        return;
    }

    $name = page_by_path($path);
    if ($name === null && !str_ends_with($path, '/') && page_by_path($path . '/') !== null) {
        redirect(url($path . '/'), 301);
    }
    if ($name === null || $name === '404') {
        http_response_code(404);
        $name = '404';
    }
    header('Content-Type: text/html; charset=utf-8');
    echo render_page($name);
}
