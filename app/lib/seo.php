<?php
/* <head>, structured data, sitemap.xml and robots.txt. */
declare(strict_types=1);

const NOINDEX_PATHS = ['/404.html', '/dekujeme/', '/dekujeme-kariera/', '/design-system/', '/nahled/'];
const SERVICE_PATHS = ['/bytovy-textil-na-miru/', '/hotelovy-textil/', '/strojni-prosivani/', '/matracove-chranice-a-potahy/', '/latky-a-metraz/'];
const DEFAULT_IMAGE = '/assets/og/century2000-og.jpg'; // 1200 × 630, sharing on social networks

function is_noindex(array $page): bool
{
    return in_array($page['path'], NOINDEX_PATHS, true);
}

/** og:image:width / height for a local image (helps Facebook and LinkedIn show the preview at once). */
function og_image_size(string $src): array
{
    $size = is_file(PUBLIC_DIR . $src) ? @getimagesize(PUBLIC_DIR . $src) : false;
    return $size ? ['<meta property="og:image:width" content="' . $size[0] . '">', '<meta property="og:image:height" content="' . $size[1] . '">'] : [];
}

function site_base(): string
{
    return rtrim((string) config('site_url'), '/');
}

/** The company: one node shared by all pages (@id …/#firma). Data from the commercial register (ARES). */
function organization_ld(): array
{
    $site = site_base();
    return [
        '@type' => ['Organization', 'LocalBusiness'],
        '@id' => $site . '/#firma',
        'name' => 'CENTURY 2000 s.r.o.',
        'alternateName' => 'Century 2000',
        'description' => 'Zakázková výroba bytového a hotelového textilu, strojní prošívání a prodej látek ve Zruči nad Sázavou.',
        'url' => $site . '/',
        'logo' => ['@type' => 'ImageObject', 'url' => $site . '/assets/icon-192.png', 'width' => 192, 'height' => 192],
        'image' => $site . DEFAULT_IMAGE,
        'telephone' => '+420603287803',
        'email' => 'info@century2000.cz',
        'foundingDate' => '1999-12-21',
        'legalName' => 'CENTURY 2000 s.r.o.',
        'taxID' => '26141116',
        'vatID' => 'CZ26141116',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Okružní 600',
            'postalCode' => '285 22',
            'addressLocality' => 'Zruč nad Sázavou',
            'addressRegion' => 'Středočeský kraj',
            'addressCountry' => 'CZ',
        ],
        'areaServed' => ['@type' => 'Country', 'name' => 'Česká republika'],
        'knowsLanguage' => ['cs'],
        'openingHoursSpecification' => [[
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens' => '07:00',
            'closes' => '15:30',
        ]],
        'contactPoint' => [[
            '@type' => 'ContactPoint', 'contactType' => 'customer service', 'telephone' => '+420603287803',
            'email' => 'info@century2000.cz', 'availableLanguage' => 'cs',
        ]],
    ];
}

function breadcrumb_ld(array $page): ?array
{
    if ($page['path'] === '/' || is_noindex($page)) {
        return null;
    }
    $site = site_base();
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
        '@type' => 'BreadcrumbList',
        '@id' => $site . $page['path'] . '#drobecky',
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
    $site = site_base();
    $o = $page['options'];
    $ld = [
        '@type' => 'Article',
        '@id' => $site . $page['path'] . '#clanek',
        'headline' => $page['name'],
        'description' => $page['meta']['description'] ?? '',
        'inLanguage' => 'cs',
        'datePublished' => $o['date'] ?? null,
        'dateModified' => $o['modified'] ?? ($o['date'] ?? null),
        'mainEntityOfPage' => ['@id' => $site . $page['path'] . '#stranka'],
        'image' => $site . ($o['image'] ?? DEFAULT_IMAGE),
        'author' => ['@id' => $site . '/#firma'],
        'publisher' => ['@id' => $site . '/#firma'],
    ];
    return array_filter($ld, fn($v) => $v !== null);
}

/** Service pages: what we make, offered by the company. */
function service_ld(array $page): ?array
{
    if (!in_array($page['path'], SERVICE_PATHS, true)) {
        return null;
    }
    $site = site_base();
    return [
        '@type' => 'Service',
        '@id' => $site . $page['path'] . '#sluzba',
        'name' => $page['name'],
        'serviceType' => $page['name'],
        'description' => $page['meta']['description'] ?? '',
        'url' => $site . $page['path'],
        'image' => $site . ($page['options']['image'] ?? DEFAULT_IMAGE),
        'provider' => ['@id' => $site . '/#firma'],
        'areaServed' => ['@type' => 'Country', 'name' => 'Česká republika'],
    ];
}

/** Questions and answers from the FAQ accordions of the rendered page (so edits in the admin carry over). */
function faq_ld(array $page, string $body): ?array
{
    if (!str_contains($body, 'data-on-click="f.toggle"')) {
        return null;
    }
    $doc = new DOMDocument();
    $prev = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8"?>' . $body, LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    $xp = new DOMXPath($doc);
    $clean = fn(?DOMNode $n) => $n ? trim(preg_replace('/\s+/u', ' ', $n->textContent) ?? '') : '';
    $qa = [];
    foreach ($xp->query('//button[@data-on-click="f.toggle"]') as $btn) {
        $q = $btn->cloneNode(true);
        foreach ((new DOMXPath($doc))->query('.//*[@aria-hidden="true"]', $q) as $hidden) {
            $hidden->parentNode->removeChild($hidden);
        }
        $idx = $btn->getAttribute('data-idx');
        // the answer is the next "f.open" panel with the same index after the question
        $answer = $xp->query('following::*[@data-if="f.open"][@data-idx="' . $idx . '"][1]', $btn)->item(0);
        $question = $clean($q);
        $text = $clean($answer);
        if ($question !== '' && $text !== '') {
            $qa[$question] = $text;
        }
    }
    if (!$qa) {
        return null;
    }
    $site = site_base();
    return [
        '@type' => 'FAQPage',
        '@id' => $site . $page['path'] . '#faq',
        'mainEntity' => array_map(fn($q, $a) => ['@type' => 'Question', 'name' => $q, 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a]],
            array_keys($qa), array_values($qa)),
    ];
}

/** All structured data of a page as one linked @graph. */
function structured_data(array $page, string $body): array
{
    $site = site_base();
    $url = $site . $page['path'];
    $type = $page['options']['type'] ?? '';
    $webpage = array_filter([
        '@type' => match (true) {
            $page['path'] === '/kontakt/' => 'ContactPage',
            $page['path'] === '/o-nas/' => 'AboutPage',
            in_array($page['path'], ['/clanky/', '/reference/'], true) => 'CollectionPage',
            default => 'WebPage',
        },
        '@id' => $url . '#stranka',
        'url' => $url,
        'name' => $page['meta']['title'] ?? $page['name'],
        'description' => ($page['meta']['description'] ?? '') ?: null,
        'inLanguage' => 'cs',
        'isPartOf' => ['@id' => $site . '/#web'],
        'about' => ['@id' => $site . '/#firma'],
        'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $site . ($page['options']['image'] ?? DEFAULT_IMAGE)],
        'breadcrumb' => $page['path'] !== '/' ? ['@id' => $url . '#drobecky'] : null,
        'dateModified' => $type === 'article' ? ($page['options']['modified'] ?? null) : null,
    ]);
    $graph = [
        organization_ld(),
        ['@type' => 'WebSite', '@id' => $site . '/#web', 'url' => $site . '/', 'name' => 'Century 2000',
         'inLanguage' => 'cs', 'publisher' => ['@id' => $site . '/#firma']],
        $webpage,
        breadcrumb_ld($page),
        service_ld($page),
        article_ld($page),
        faq_ld($page, $body),
    ];
    return ['@context' => 'https://schema.org', '@graph' => array_values(array_filter($graph))];
}

function seo_head(array $page, string $body = ''): string
{
    $site = site_base();
    $title = $page['meta']['title'] ?? '';
    $desc = $page['meta']['description'] ?? '';
    $url = $site . $page['path'];
    $image = $site . ($page['options']['image'] ?? DEFAULT_IMAGE);
    $noindex = is_noindex($page);

    $l = [
        '<meta charset="utf-8">',
        '<meta name="viewport" content="width=device-width, initial-scale=1">',
        '<title>' . e($title) . '</title>',
        tracking_head(), // Consent Mode v2 defaults: before any other script
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
            '<meta property="og:image:alt" content="' . e($title) . '">',
            '<meta name="twitter:card" content="summary_large_image">'
        );
        array_push($l, ...og_image_size($page['options']['image'] ?? DEFAULT_IMAGE));
    }
    array_push($l,
        '<meta name="theme-color" content="#F8F5F0">',
        '<link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">',
        '<link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">',
        '<link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">',
        '<link rel="preload" href="/assets/fonts/barlow-400-latin.woff2" as="font" type="font/woff2" crossorigin>',
        '<link rel="preload" href="/assets/fonts/playfair-display-500-latin.woff2" as="font" type="font/woff2" crossorigin>',
        '<link rel="stylesheet" href="/assets/fonts/fonts.css?v=' . asset_version('fonts/fonts.css') . '">'
    );
    $l[] = '<script>if (!window.matchMedia || !matchMedia("(prefers-reduced-motion: reduce)").matches) document.documentElement.classList.add("js-anim")</script>';
    foreach (array_unique(array_merge(['base', 'components', 'pages', 'obsah'], $page['options']['css'] ?? [], ['animace'])) as $css) {
        $l[] = '<link rel="stylesheet" href="/assets/css/' . $css . '.css?v=' . asset_version("css/$css.css") . '">';
    }
    $custom = trim(tracking_custom('head'));
    if ($custom !== '') {
        $l[] = $custom;
    }
    $l[] = '<script src="/assets/js/site.js?v=' . asset_version('js/site.js') . '" defer></script>';
    $l[] = '<script src="/assets/js/animace.js?v=' . asset_version('js/animace.js') . '" defer></script>';
    if (!$noindex) {
        $l[] = '<script type="application/ld+json">' . json_encode(structured_data($page, $body), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) . '</script>';
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
        if (is_noindex($page) || !empty($page['options']['hidden'])) {
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
    return "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /odeslat/\n\nSitemap: " . rtrim((string) config('site_url'), '/') . "/sitemap.xml\n";
}
