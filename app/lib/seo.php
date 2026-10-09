<?php
/* <head>, structured data, sitemap.xml and robots.txt. */
declare(strict_types=1);

const NOINDEX_PATHS = ['/404.html', '/dekujeme/', '/dekujeme-kariera/', '/design-system/', '/nahled/'];
const SERVICE_PATHS = ['/bytovy-textil-na-miru/', '/hotelovy-textil/', '/strojni-prosivani/', '/matracove-chranice-a-potahy/', '/latky-a-metraz/'];
const DEFAULT_IMAGE = '/assets/fotky/hero-sici-dilna.webp';

function is_noindex(array $page): bool
{
    return in_array($page['path'], NOINDEX_PATHS, true);
}

function organization_ld(): array
{
    $site = rtrim((string) config('site_url'), '/');
    return [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        '@id' => $site . '/#firma',
        'name' => 'CENTURY 2000 s.r.o.',
        'description' => 'Zakázková výroba bytového a hotelového textilu, strojní prošívání a prodej látek ve Zruči nad Sázavou.',
        'url' => $site . '/',
        'logo' => $site . '/assets/logo/century2000-logo.svg',
        'image' => $site . DEFAULT_IMAGE,
        'telephone' => '+420603287803',
        'email' => 'info@century2000.cz',
        'foundingDate' => '2000',
        'vatID' => 'CZ26141116',
        'identifier' => 'IČ 26141116',
        'address' => [ // fakturační adresa / sídlo z kontaktní stránky starého webu (2024): potvrdit u klienta
            '@type' => 'PostalAddress',
            'streetAddress' => 'Okružní 600',
            'postalCode' => '285 22',
            'addressLocality' => 'Zruč nad Sázavou',
            'addressCountry' => 'CZ',
        ],
        'openingHoursSpecification' => [[
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens' => '07:00',
            'closes' => '15:30',
        ]],
    ];
}

function breadcrumb_ld(array $page): ?array
{
    if ($page['path'] === '/' || is_noindex($page)) {
        return null;
    }
    $site = rtrim((string) config('site_url'), '/');
    $items = [['Úvod', '/']];
    if (in_array($page['path'], SERVICE_PATHS, true)) {
        $items[] = ['Služby', '/#co-sijeme'];
    }
    $type = $page['options']['type'] ?? '';
    if ($type === 'article') {
        $items[] = ['Články', '/clanky/'];
    } elseif ($type === 'reference') {
        $items[] = ['Reference', '/reference/'];
    }
    $items[] = [$page['name'], $page['path']];
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array_map(fn($i, $n) => [
            '@type' => 'ListItem', 'position' => $n + 1, 'name' => $i[0], 'item' => $site . $i[1],
        ], $items, array_keys($items)),
    ];
}

/** Article structured data for pages of type "article". */
function article_ld(array $page): ?array
{
    if (($page['options']['type'] ?? '') !== 'article') {
        return null;
    }
    $site = rtrim((string) config('site_url'), '/');
    $o = $page['options'];
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $page['name'],
        'description' => $page['meta']['description'] ?? '',
        'inLanguage' => 'cs',
        'datePublished' => $o['date'] ?? null,
        'dateModified' => $o['modified'] ?? ($o['date'] ?? null),
        'mainEntityOfPage' => $site . $page['path'],
        'image' => $site . ($o['image'] ?? DEFAULT_IMAGE),
        'author' => ['@type' => 'Organization', 'name' => 'CENTURY 2000 s.r.o.'],
        'publisher' => ['@type' => 'Organization', 'name' => 'CENTURY 2000 s.r.o.', 'logo' => ['@type' => 'ImageObject', 'url' => $site . '/assets/logo/century2000-logo.svg']],
    ];
    return array_filter($ld, fn($v) => $v !== null);
}

function seo_head(array $page): string
{
    $site = rtrim((string) config('site_url'), '/');
    $title = $page['meta']['title'] ?? '';
    $desc = $page['meta']['description'] ?? '';
    $url = $site . $page['path'];
    $image = $site . ($page['options']['image'] ?? DEFAULT_IMAGE);
    $noindex = is_noindex($page);

    $l = [
        '<meta charset="utf-8">',
        '<meta name="viewport" content="width=device-width, initial-scale=1">',
        '<title>' . e($title) . '</title>',
    ];
    if ($desc !== '') {
        $l[] = '<meta name="description" content="' . e($desc) . '">';
    }
    if ($noindex || config('demo')) {
        $l[] = '<meta name="robots" content="noindex, follow">';
    }
    if (!$noindex) {
        array_push($l,
            '<link rel="canonical" href="' . e($url) . '">',
            '<meta property="og:type" content="' . (($page['options']['type'] ?? '') === 'article' ? 'article' : 'website') . '">',
            '<meta property="og:locale" content="cs_CZ">',
            '<meta property="og:site_name" content="Century 2000">',
            '<meta property="og:title" content="' . e($title) . '">',
            '<meta property="og:description" content="' . e($desc) . '">',
            '<meta property="og:url" content="' . e($url) . '">',
            '<meta property="og:image" content="' . e($image) . '">',
            '<meta name="twitter:card" content="summary_large_image">'
        );
    }
    array_push($l,
        '<meta name="theme-color" content="#F8F5F0">',
        '<link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">',
        '<link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">',
        '<link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">',
        '<link rel="preconnect" href="https://fonts.googleapis.com">',
        '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>',
        '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&amp;family=Parisienne&amp;family=Playfair+Display:ital,wght@0,500;0,600;1,500&amp;display=swap">'
    );
    $l[] = '<script>if (!window.matchMedia || !matchMedia("(prefers-reduced-motion: reduce)").matches) document.documentElement.classList.add("js-anim")</script>';
    foreach (array_unique(array_merge(['base', 'components', 'pages', 'obsah'], $page['options']['css'] ?? [], ['animace'])) as $css) {
        $l[] = '<link rel="stylesheet" href="/assets/css/' . $css . '.css?v=' . asset_version("css/$css.css") . '">';
    }
    $ga = (string) config('analytics.ga4_id', '');
    if (preg_match('/^G-[A-Z0-9]{6,12}$/', $ga)) {
        $l[] = '<meta name="c2000-ga4" content="' . e($ga) . '">'; // loaded by site.js only after consent
    }
    $l[] = '<script src="/assets/js/site.js?v=' . asset_version('js/site.js') . '" defer></script>';
    $l[] = '<script src="/assets/js/animace.js?v=' . asset_version('js/animace.js') . '" defer></script>';
    if (!$noindex) {
        $ld = array_filter([in_array($page['path'], ['/', '/kontakt/', '/o-nas/'], true) ? organization_ld() : null, breadcrumb_ld($page), article_ld($page)]);
        foreach ($ld as $data) {
            $l[] = '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
        }
    }
    return '  ' . implode("\n  ", $l);
}

/** Cache-busting version from the file's modification time. */
function asset_version(string $file): string
{
    $f = PUBLIC_DIR . '/assets/' . $file;
    return is_file($f) ? base_convert((string) filemtime($f), 10, 36) : '1';
}

function sitemap_xml(): string
{
    $site = rtrim((string) config('site_url'), '/');
    $out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    foreach (content_pages() as $name => $page) {
        if (is_noindex($page)) {
            continue;
        }
        $mod = $page['options']['modified'] ?? date('Y-m-d', filemtime(content_file((string) $name)));
        $out .= '  <url><loc>' . e($site . $page['path']) . "</loc><lastmod>$mod</lastmod></url>\n";
    }
    return $out . "</urlset>\n";
}

function robots_txt(): string
{
    if (config('demo')) {
        return "User-agent: *\nDisallow: /\n";
    }
    return "User-agent: *\nAllow: /\nDisallow: /admin/\n\nSitemap: " . rtrim((string) config('site_url'), '/') . "/sitemap.xml\n";
}
