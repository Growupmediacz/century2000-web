<?php
/*
 * Measurement codes and Google Consent Mode v2.
 *
 * Settings are edited in the admin (Měřicí kódy) and stored in content/mereni.json (not in Git, like other
 * client edits). Every tag waits for the visitor's choice in the cookie bar:
 *   analytics  → analytics_storage, GA4, custom codes marked "analytics"
 *   marketing  → ad_storage, ad_user_data, ad_personalization, Google Ads, Meta Pixel, Sklik, custom "marketing" codes
 * Mode "basic": Google tags are not loaded at all before consent (safest under EU law).
 * Mode "advanced": Google tags load at once with everything denied and send only cookieless pings until consent
 *   (Google's recommended setup, gives modelled conversions; needs the client's/lawyer's approval).
 */
declare(strict_types=1);

const TRACKING_FILE = 'mereni.json';

/** Field definitions: key => [label, validation regex|null, help]. */
const TRACKING_IDS = [
    'ga4_id' => ['Google Analytics 4 – ID měření', '/^G-[A-Z0-9]{4,15}$/', 'Např. G-AB12CD34EF. Najdete v GA4: Správce → Datové proudy.'],
    'gtm_id' => ['Google Tag Manager – ID kontejneru', '/^GTM-[A-Z0-9]{4,10}$/', 'Např. GTM-ABC1234. Používáte-li GTM, GA4 a Google Ads nastavte raději v něm a pole výše nechte prázdná.'],
    'ads_id' => ['Google Ads – ID konverze', '/^AW-\d{6,14}$/', 'Např. AW-123456789. Spustí se jen se souhlasem s marketingovými cookies.'],
    'meta_pixel' => ['Meta (Facebook) Pixel – ID', '/^\d{10,20}$/', 'Jen číslice. Spustí se jen se souhlasem s marketingovými cookies.'],
    'sklik_id' => ['Sklik (Seznam) – ID retargetingu', '/^\d{3,12}$/', 'Jen číslice. Spustí se jen se souhlasem s marketingovými cookies.'],
];

function tracking_defaults(): array
{
    return ['mode' => 'basic', 'ga4_id' => (string) config('analytics.ga4_id', ''), 'gtm_id' => '', 'ads_id' => '',
            'meta_pixel' => '', 'sklik_id' => '', 'custom' => [
                ['label' => '', 'category' => 'analytics', 'place' => 'head', 'code' => ''],
                ['label' => '', 'category' => 'marketing', 'place' => 'body', 'code' => ''],
            ], 'updated' => ''];
}

function tracking_settings(): array
{
    static $cache = null;
    if ($cache === null) {
        $file = CONTENT_DIR . '/' . TRACKING_FILE;
        $saved = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
        $cache = array_replace(tracking_defaults(), is_array($saved) ? $saved : []);
    }
    return $cache;
}

function tracking_save(array $data): void
{
    write_file_atomic(CONTENT_DIR . '/' . TRACKING_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
}

/** Which consent categories are actually used (for the cookie bar and the cookie policy). */
function tracking_uses(string $category): bool
{
    $t = tracking_settings();
    $custom = array_filter($t['custom'], fn($c) => trim((string) $c['code']) !== '' && $c['category'] === $category);
    return match ($category) {
        'analytics' => $t['ga4_id'] !== '' || $t['gtm_id'] !== '' || (bool) $custom,
        'marketing' => $t['ads_id'] !== '' || $t['meta_pixel'] !== '' || $t['sklik_id'] !== '' || $t['gtm_id'] !== '' || (bool) $custom,
        default => false,
    };
}

/**
 * First thing in <head>: Consent Mode v2 defaults (everything denied), the visitor's earlier choice applied
 * synchronously, and the tag configuration for site.js. Must come before any Google tag.
 */
function tracking_head(): string
{
    $t = tracking_settings();
    $cfg = ['mode' => $t['mode'] === 'advanced' ? 'advanced' : 'basic'];
    foreach (array_keys(TRACKING_IDS) as $k) {
        if ($t[$k] !== '') {
            $cfg[$k] = $t[$k];
        }
    }
    $js = <<<'JS'
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}
gtag('consent','default',{ad_storage:'denied',ad_user_data:'denied',ad_personalization:'denied',analytics_storage:'denied',functionality_storage:'granted',security_storage:'granted',wait_for_update:500});
gtag('set','ads_data_redaction',true);
(function(){try{var c=JSON.parse(localStorage.getItem('c2000-consent'));if(c&&c.v===2&&Date.now()-new Date(c.date).getTime()<31536e6){gtag('consent','update',{analytics_storage:c.analytics?'granted':'denied',ad_storage:c.marketing?'granted':'denied',ad_user_data:c.marketing?'granted':'denied',ad_personalization:c.marketing?'granted':'denied'});}}catch(e){}})();
JS;
    return '<script>' . $js . '</script>' . "\n  " .
        '<script type="application/json" id="c2000-tracking">' . json_encode($cfg, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) . '</script>';
}

/**
 * Custom codes from the admin, inert until consent: <template> content is not executed; site.js clones it
 * (re-creating <script> elements) once the visitor agrees to the code's category.
 */
function tracking_custom(string $place): string
{
    $out = '';
    foreach (tracking_settings()['custom'] as $i => $c) {
        if (trim((string) $c['code']) === '' || $c['place'] !== $place) {
            continue;
        }
        $cat = in_array($c['category'], ['necessary', 'analytics', 'marketing'], true) ? $c['category'] : 'marketing';
        $out .= '<template data-c2000-code="' . $cat . '" data-place="' . e($place) . '">' . $c['code'] . '</template>' . "\n";
    }
    return $out;
}

/**
 * Cookies the configured tools set, for the cookie policy table: [category, name, purpose, provider, duration].
 */
function tracking_cookie_rows(): array
{
    $t = tracking_settings();
    $rows = [
        ['necessary', 'c2000-consent', 'uloží vaši volbu v liště cookies (úložiště prohlížeče)', 'Century 2000', '12 měsíců'],
    ];
    if ($t['ga4_id'] !== '' || $t['gtm_id'] !== '') {
        $rows[] = ['analytics', '_ga, _ga_*', 'statistika návštěvnosti: rozliší jednotlivé návštěvníky a jejich relace', 'Google Ireland Ltd. (Google Analytics)', '2 roky'];
    }
    if ($t['ads_id'] !== '' || $t['gtm_id'] !== '') {
        $rows[] = ['marketing', '_gcl_au, _gcl_aw', 'měření konverzí z reklam Google', 'Google Ireland Ltd. (Google Ads)', '90 dní'];
    }
    if ($t['meta_pixel'] !== '') {
        $rows[] = ['marketing', '_fbp, fr', 'měření a cílení reklam na Facebooku a Instagramu', 'Meta Platforms Ireland Ltd.', '90 dní'];
    }
    if ($t['sklik_id'] !== '') {
        $rows[] = ['marketing', 'sid, udid, KADUSERCOOKIE', 'retargeting a měření reklam v síti Seznam', 'Seznam.cz, a.s.', 'až 13 měsíců'];
    }
    foreach ($t['custom'] as $c) {
        if (trim((string) $c['code']) !== '' && trim((string) $c['label']) !== '') {
            $rows[] = [$c['category'], '–', (string) $c['label'], 'viz zásady poskytovatele', '–'];
        }
    }
    return $rows;
}

/**
 * Content Security Policy for the public pages: scripts only from this site and from the measurement tools that are
 * filled in the admin. An injected <script src="https://attacker…"> is then blocked by the browser.
 * GTM and custom codes can load scripts from anywhere (that is what they are for), so with them only HTTPS is required.
 */
function public_csp(): string
{
    $t = tracking_settings();
    $hosts = [];
    $open = $t['gtm_id'] !== '';
    if ($t['ga4_id'] !== '' || $t['ads_id'] !== '' || $t['gtm_id'] !== '') {
        array_push($hosts, 'https://www.googletagmanager.com', 'https://*.google-analytics.com', 'https://*.analytics.google.com');
    }
    if ($t['ads_id'] !== '' || $t['gtm_id'] !== '') {
        array_push($hosts, 'https://www.googleadservices.com', 'https://googleads.g.doubleclick.net', 'https://www.google.com', 'https://*.googlesyndication.com');
    }
    if ($t['meta_pixel'] !== '') {
        $hosts[] = 'https://connect.facebook.net';
    }
    if ($t['sklik_id'] !== '') {
        array_push($hosts, 'https://c.seznam.cz', 'https://*.seznam.cz');
    }
    foreach ($t['custom'] as $c) {
        if (trim((string) $c['code']) === '') {
            continue;
        }
        preg_match_all('#\bsrc=["\']?(https://[a-z0-9.-]+)#i', (string) $c['code'], $m);
        $hosts = array_merge($hosts, $m[1]);
        // inline loaders (Hotjar, LinkedIn…) add their scripts from code we cannot see in advance
        if (preg_match('#<script\b(?![^>]*\bsrc=)#i', (string) $c['code'])) {
            $open = true;
        }
    }
    // inline scripts: Consent Mode defaults, JSON config, tracking loaders
    $script = $open ? "'self' 'unsafe-inline' https:" : trim("'self' 'unsafe-inline' " . implode(' ', array_unique($hosts)));
    return "default-src 'self'; script-src $script; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; "
        . "font-src 'self'; connect-src 'self' https:; frame-src 'self' https:; media-src 'self' https:; "
        . "object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'"
        . (($_SERVER['HTTPS'] ?? '') !== '' && $_SERVER['HTTPS'] !== 'off' ? '; upgrade-insecure-requests' : '');
}
