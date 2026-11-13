<?php
/*
 * 301 redirects from the old Joomla site (backup 19. 2. 2024) to the new addresses.
 * Single source: used by the PHP router, by `php tools/sync-redirects.php` (writes the block in
 * public/.htaccess and docs/redirects.md) and by the static export (meta-refresh pages).
 * Keys are old paths without a trailing slash. Values are new paths or full URLs.
 */
return [
    '/index.php'                                        => '/',
    '/siti-bytoveho-textilu'                            => '/bytovy-textil-na-miru/',
    '/siti-bytoveho-textilu/okenni-dekorace'            => '/bytovy-textil-na-miru/',
    '/siti-bytoveho-textilu/potahy-na-zidle'            => '/bytovy-textil-na-miru/',
    '/siti-bytoveho-textilu/prehozy-a-polstarky'        => '/bytovy-textil-na-miru/',
    '/siti-bytoveho-textilu/rautove-sukne'              => '/hotelovy-textil/',
    '/siti-bytoveho-textilu/vyroba-textilnich-vzorkovnic' => '/vzorkovniky/',
    '/siti-potahu-na-matrace'                           => '/matracove-chranice-a-potahy/',
    '/siti-potahu-na-matrace/matracove-chranice'        => '/matracove-chranice-a-potahy/',
    '/siti-potahu-na-matrace/potahy-na-matrace-a-vyplne-polstaru' => '/matracove-chranice-a-potahy/',
    '/prosev-materialu'                                 => '/strojni-prosivani/',
    '/prodej-metraze'                                   => '/latky-a-metraz/',
    '/prodej-metraze/zaclony'                           => '/latky-a-metraz/#zaclony',
    '/prodej-metraze/ubrusoviny'                        => '/latky-a-metraz/#ubrusoviny',
    '/prodej-metraze/blackouty'                         => '/latky-a-metraz/#blackouty',
    '/prodej-metraze/dimouty'                           => '/latky-a-metraz/#dimouty',
    '/prodej-metraze/dekoracni-latky'                   => '/latky-a-metraz/#dekoracni-latky',
    '/prodej-metraze/dekoracni-latky-s-nehorlavou-upravou' => '/latky-a-metraz/#nehorlave-latky',
    '/prodej-metraze/polyesterova-rouna-a-netkane-textilie' => '/latky-a-metraz/#rouna',
    '/prodej-metraze/materialy-pro-vyrobu-potahu-na-matrace' => '/latky-a-metraz/#materialy-na-potahy',
    '/prodej-metraze/maloobchodni-prodej'               => '/latky-a-metraz/',
    '/produkty/latky-na-ubrusy'                         => '/clanky/latky-na-ubrusy-a-prostirani/',
    '/e-shop'                                           => 'https://century2000-cz.webnode.cz/',
    // /o-nas, /kontakt, /reference, /vzorkovniky and /reference/<alias> keep their address
    // (the router adds the trailing slash with a 301), so they need no entry.
];
