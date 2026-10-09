<?php
/*
 * Century 2000 – configuration.
 * Copy to config.php (or run: php tools/set-password.php, which creates it) and fill in.
 * config.php is not in Git – it holds the admin password hash and mail credentials.
 */
return [
    // Production address (canonical URLs, sitemap, Open Graph).
    'site_url' => 'https://www.century2000.cz',

    // Web served from a subfolder? e.g. '/web'. Empty = domain root.
    'base_path' => '',

    // INDEXING SWITCH. true = whole site is hidden from search engines (noindex meta + robots.txt "Disallow: /").
    // Keep true on the preview/test domain. Set to false ONLY when the site goes live on century2000.cz.
    'demo' => false,

    // Google Analytics 4 measurement ID (G-XXXXXXXXXX), supplied by the client. Empty = no analytics code is
    // loaded at all. With an ID the script is loaded only after the visitor accepts analytics cookies.
    'analytics' => [
        'ga4_id' => '',
    ],

    // Random string for signing form tokens. set-password.php generates it.
    'secret' => '',

    // Administration (/admin/). Password hash: php tools/set-password.php
    'admin' => [
        'user' => 'admin',
        'password_hash' => '',
    ],

    // Form e-mails.
    'mail' => [
        'to' => 'info@century2000.cz',          // inquiries
        'to_career' => 'info@century2000.cz',   // job applications
        'from' => 'web@century2000.cz',         // must be a mailbox on the web's domain
        'from_name' => 'Web Century 2000',
        // 'mail' = PHP mail() (works on Webglobe), 'smtp' = mailbox login, 'log' = save to content/.runtime/mail (testing)
        'transport' => 'mail',
        'smtp' => [
            'host' => '',        // e.g. smtp.webglobe.cz
            'port' => 465,
            'secure' => 'ssl',   // 'ssl' (465) or 'tls' (587)
            'user' => '',
            'password' => '',
        ],
    ],
];
