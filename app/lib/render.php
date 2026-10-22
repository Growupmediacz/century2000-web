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

/** Plain text field with line breaks kept (Enter in the admin = new line on the web). */
function tbr(string $ref): string
{
    return nl2br(t($ref), false);
}

/** Link target from a text field (button address), or $default when the field is empty or not a safe URL. */
function link_value(string $ref, string $default): string
{
    $v = trim((string) (content_field($ref)['value'] ?? ''));
    return $v !== '' && preg_match('~^(https?://|mailto:|tel:|/|#)~i', $v) ? $v : $default;
}

/** srcset attribute for an image with -640 / -1280 variants next to it (none for uploaded images). */
function img_srcset(string $src, string $sizes): string
{
    if (!preg_match('/^(.+)\.(webp|jpe?g|png)$/i', $src, $m) || !is_file(PUBLIC_DIR . $src)) {
        return '';
    }
    $set = [];
    foreach ([640, 1280] as $w) {
        if (is_file(PUBLIC_DIR . "$m[1]-$w.$m[2]")) {
            $set[] = "$m[1]-$w.$m[2] {$w}w";
        }
    }
    if (!$set) {
        return '';
    }
    $size = @getimagesize(PUBLIC_DIR . $src);
    $set[] = $src . ' ' . ($size[0] ?? 2400) . 'w';
    return ' srcset="' . e(implode(', ', $set)) . '" sizes="' . e($sizes) . '"';
}

/** Inline SVG icon from public/assets/ikony/<name>.svg, so it inherits the text colour. */
function icon_svg(string $name, string $class = ''): string
{
    static $cache = [];
    $file = PUBLIC_DIR . '/assets/ikony/' . $name . '.svg';
    if (!preg_match('~^[a-z0-9/-]+$~', $name) || !is_file($file)) {
        return '';
    }
    $svg = $cache[$name] ??= trim((string) file_get_contents($file));
    return preg_replace('/^<svg\b/', '<svg class="' . e($class) . '" aria-hidden="true" focusable="false"', $svg) ?? '';
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
    include APP_DIR . '/templates/pages/' . ($page['options']['template'] ?? $name) . '.php';
    $body = trim((string) ob_get_clean());

    $html = "<!DOCTYPE html>\n<html lang=\"cs\">\n<head>\n" . seo_head($page, $body) . "\n</head>\n<body>\n$body\n" . tracking_custom('body') . "</body>\n</html>\n";
    return finalize_html($html, $page['path'], !empty($page['options']['absolute']));
}

/**
 * width/height on local raster images that lack them, so the browser reserves the space before the image loads
 * (no layout shift, better Core Web Vitals). CSS keeps the real size (img { height: auto } in base.css).
 */
function add_image_sizes(string $html): string
{
    static $sizes = [];
    return preg_replace_callback('#<img\b(?![^>]*\swidth=)([^>]*?)\ssrc="(/[^"?]+\.(?:webp|jpe?g|png|gif))"#i', function ($m) use (&$sizes) {
        $file = PUBLIC_DIR . $m[2];
        $sizes[$m[2]] ??= is_file($file) ? (@getimagesize($file) ?: null) : null;
        $size = $sizes[$m[2]];
        return $size ? "<img{$m[1]} src=\"{$m[2]}\" width=\"{$size[0]}\" height=\"{$size[1]}\"" : $m[0];
    }, $html) ?? $html;
}

/** aria-current on links to the current page; base path for root-relative URLs. */
function finalize_html(string $html, string $path, bool $absolute = false): string
{
    $html = add_image_sizes($html);
    $html = preg_replace('/(<a\b[^>]*\shref="' . preg_quote($path, '/') . '")/', '$1 aria-current="page"', $html);
    $base = rtrim((string) config('base_path', ''), '/');
    if ($base !== '') {
        $html = preg_replace('#\b(href|src|action|data-thanks)="/(?!/)#', '$1="' . $base . '/', $html);
        $html = preg_replace_callback('#\bsrcset="([^"]*)"#', fn($m) => 'srcset="' . preg_replace('#(^|,\s*)/(?!/)#', '$1' . $base . '/', $m[1]) . '"', $html);
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

    $target = redirect_target($path);
    if ($target !== null) {
        redirect(str_starts_with($target, 'http') ? $target : url($target), 301);
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
