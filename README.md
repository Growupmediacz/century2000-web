# Century 2000 – web s administrací

Web v PHP (bez databáze) podle návrhu z Claude Design. Klient si v administraci na `/admin/` sám upraví texty, vymění obrázky a skryje sekce. Formuláře (poptávka, žádost o práci) se odesílají e-mailem.

Požadavky: PHP 8.1+ s rozšířeními `gd` (s WebP), `mbstring`, `dom`. Webglobe to splňuje.

## Struktura

```
public/            kořen webu (na hostingu složka www)
  index.php        router: stránky, formuláře, sitemap.xml, robots.txt
  .htaccess        čisté adresy, zabezpečení, cache
  admin/           administrace (/admin/)
  assets/          CSS, JS, fotky, loga
  uploads/         obrázky nahrané v administraci
app/               kód (není veřejně dostupný)
  lib/             obsah, vykreslení, SEO, formuláře, e-mail
  admin/           administrace – logika a obrazovky
  templates/       HTML šablony stránek a společných částí (hlavička, patička, cookie lišta)
content/           obsah upravovaný v administraci (JSON), zálohy verzí
config.php         heslo do administrace a nastavení e-mailu (není v Gitu)
tools/             pomocné skripty
```

**Kdo co upravuje:**
- **klient v administraci:** texty, obrázky, zobrazení sekcí, titulky a popisy pro Google (ukládá se do `content/`)
- **vývojář v kódu:** vzhled a rozvržení (`app/templates`, `public/assets/css`)

## Lokální vývoj

```bash
php tools/set-password.php          # vytvoří config.php a nastaví heslo do administrace
php -S localhost:8000 -t public public/index.php
```

Web poběží na http://localhost:8000, administrace na http://localhost:8000/admin/.
Pro testování nastavte v `config.php` `'transport' => 'log'`. E-maily se pak neodesílají, ukládají se do `content/.runtime/mail/`.

## Nasazení na Webglobe

1. Na FTP nahrajte obsah složky `public/` do `www/` a vedle `www/` složky `app/`, `content/` a soubor `config.php`.
   Pokud hosting soubory mimo `www/` nedovolí, dejte vše do `www/`. `.htaccess` pak zablokuje přístup do `app/`, `content/` a ke `config.php`.
2. Složky `content/`, `www/uploads/` a `www/downloads/vzorkovniky/` musí mít právo zápisu (PHP do nich ukládá). PHP limit `upload_max_filesize` / `post_max_size` nastavte aspoň na 40 MB kvůli PDF vzorkovníkům.
3. V `config.php` nastavte `mail.from` (schránka na doméně webu, např. `web@century2000.cz`) a `mail.to`.
   `transport => 'mail'` funguje na Webglobe bez dalšího nastavení. Spolehlivější je `smtp` s přihlášením ke schránce.
4. Na hostingu zapněte SSL certifikát (Webglobe: Let's Encrypt zdarma). `.htaccess` přesměruje všechny adresy na HTTPS sám. Přesměrování na `www` odkomentujte až na ostré doméně.
5. `public/.user.ini` nastaví PHP: chyby se nezobrazují návštěvníkům, limit nahrávání 40 MB, bezpečné session. Pokud hosting `.user.ini` nečte, nastavte to samé v administraci hostingu.
6. Přístup do administrace: `php tools/set-password.php` vytvoří `config.php` s heslem. Pro ukázku klientovi je v lokálním `config.php` dočasný účet (viz Zabezpečení). Klient si heslo změní sám v Administrace → Nastavení.

**Při dalších nasazeních nepřepisujte `content/`, `www/uploads/`, `www/downloads/vzorkovniky/` ani `config.php`.** Jsou v nich úpravy klienta a hesla.

## Náhled pro klienta (GitHub Pages)

Každý push do `main` spustí `.github/workflows/pages.yml`. Ten web vyexportuje do statického HTML (`php tools/export-static.php --demo`) a zveřejní ho na https://growupmediacz.github.io/century2000-web/ (skrytý před vyhledávači).
Náhled ukazuje obsah z Gitu, ne úpravy z administrace na ostrém webu. Formuláře v něm jen přesměrují na děkovací stránku.

## Administrace

Návrh obrazovek: `docs/cms-navrh/` (Higgsfield, statické obrázky).

- přihlášení jménem a heslem (heslo nastaví `php tools/set-password.php`), po 5 chybných pokusech se přihlašování na 15 minut zablokuje. Klient si heslo změní sám v **Nastavení**, nové heslo se uloží do `content/.runtime/admin.json` a má přednost před `config.php`
- **Přehled:** rychlé akce (úvodní stránka, nová reference, nový článek, vzorkovník), naposledy upravené stránky, stav webu (testovací režim, zálohy)
- stránky rozdělené na sekce: texty (u víceřádkových polí Enter = nový řádek na webu), formátovaný text (tučně, kurzíva, odkazy), obrázky s popisem, nápověda u polí a přepínač **Zobrazit sekci na webu**
- **Úvodní stránka, hero:** nadtitulek, nadpis, text, dvě tlačítka (text i odkaz), ozdobný ručně psaný nápis, fotka pro počítač a mobil, 4 přednosti s ikonami (`public/assets/ikony/hero/`)
- **Reference:** seznam s pořadím (šipky), logem a přepínačem **Na úvodní stránce**. V detailu logo hotelu (nahrát / odstranit), fotky, texty, **Zobrazit referenci na webu**, smazání
- **Články:** skládají se z bloků Odstavec, Obrázek s popiskem, Rámeček „Dobré vědět“. Bloky jde přidat, posunout a odstranit. Datum, služby, u kterých se článek nabízí, **Zobrazit článek na webu** (nový článek je skrytý, dokud ho klient nezapne), smazání
- **Vzorkovníky:** nahrání PDF (max. 40 MB, kontroluje se, že jde o PDF), přejmenování, pořadí, skrytí, smazání
- smazané články, reference a PDF se přesunou do `content/backups/_smazane/`, nic se nemaže natrvalo
- nahrané fotky se automaticky otočí, zmenší na max. 2400 px a převedou do WebP
- před každým uložením se uloží předchozí verze. **Historie verzí** umožní obnovit kteroukoli z posledních 30.

## SEO

- **Titulky a popisy:** každá stránka má vlastní titulek (do 60 znaků) a popis (100–160 znaků), upravují se v administraci v sekci „Vyhledávače (SEO)“. Jedna `<h1>` na stránku (desktopová kopie nadpisu v hero je `<p role="heading">`).
- **Hlavička:** canonical, Open Graph (výchozí obrázek pro sdílení `public/assets/og/century2000-og.jpg`, 1200 × 630, s rozměry a alt textem), Twitter card, `lang="cs"`.
- **Strukturovaná data** (`app/lib/seo.php`, `structured_data()`): jeden propojený `@graph` na každé stránce. Firma (`Organization` + `LocalBusiness` s údaji z obchodního rejstříku, adresou, otevírací dobou, IČO a DIČ), `WebSite`, `WebPage` (`ContactPage`, `AboutPage`, `CollectionPage`), drobečková navigace, `Service` na stránkách služeb, `Article` u článků a `FAQPage` z rozbalovacích otázek (čte se z vykreslené stránky, takže úpravy v administraci se propíšou samy). Ověřeno validátorem schema.org bez chyb.
- **Rychlost:** obrázky dostanou `width` a `height` automaticky (`add_image_sizes()` v `app/lib/render.php`), stránka se při načítání neposouvá. Úvodní fotka má `srcset` a `fetchpriority="high"`, písma jsou lokálně s `preload`.
- **Sitemap a robots:** dynamická `sitemap.xml` (bez skrytých a interních stránek), `robots.txt` blokuje `/admin/` a `/odeslat/`. `noindex` pro děkovací stránky, 404 a interní stránky (`/nahled/`, `/design-system/`). Celý web je `noindex`, dokud je v `config.php` `'demo' => true`.
- **Přesměrování:** staré adresy z Joomly přes `.htaccess` (301), odkazy na sekce dosavadního jednostránkového webu (`/#kontakt`, `/#reference`, `/#o-nas`, `/#oblasti`) přes `site.js`.
- Údaje o firmě jsou v `content/global.json` (patička) a v `app/lib/seo.php`.

## Reference, články, vzorkovníky: jak přidat a upravit

Všechno je ve stejném systému jako ostatní stránky (JSON v `content/pages/`, úpravy v administraci):

- **Článek:** `/admin/` → *Články* → pole „Název nového článku“ → *Napsat článek*. Otevře se editor: hlavička (nadpis, perex, obrázek), bloky (odstavec `blok-N`, obrázek s popiskem `foto-N`, rámeček „Dobré vědět“ `tip-N`), související služba. Bloky se přidávají, posouvají a mažou tlačítky v editoru. Pořadí sekcí v souboru je pořadí v článku. Stejné bloky dostane každá stránka s `options.blocks: true`. V `options.related` jsou adresy souvisejících článků a v `options.service` stránky služeb, na kterých se článek nabízí jako doporučený. Adresa je `/clanky/<slug>/`, zařadí se do výpisu, sitemapy a strukturovaných dat (Article). Články jsou odkazované z patičky, ne z hlavního menu.
- **Reference (realizace):** `/admin/` → *Reference* → *Přidat realizaci*. Každá realizace má vlastní stránku `/reference/<slug>/` (hlavní fotka, co jsme šili, popis, poznámka o spolupráci, galerie). Karty na stránce Reference, seznam na úvodní stránce a na stránce Hotelový textil se plní z těchto souborů, takže jsou vždy shodné. Pořadí určuje `options.order` (v administraci šipkami), v pruhu pod úvodní fotkou a na stránce Hotelový textil se zobrazí realizace s `options.featured: true` (přepínač „Na úvodní stránce“). Logo hotelu je v sekci `logo` dané reference (`public/assets/reference-loga/`), bez loga se ukáže název hotelu.
- **Vzorkovníky:** `/admin/` → *Vzorkovníky*. PDF jsou v `public/downloads/vzorkovniky/` (složka musí mít právo zápisu), seznam (název, velikost, skrytí) je v `content/pages/vzorkovniky.json` v `options.files`.
- **Starý obsah:** texty o látkách jsou na stránce Látky a metráž v sekcích „Materiál: …“ (`blok-*`), kotvy `#blackouty`, `#zaclony` apod. používají přesměrování.

Obrázky na webu jsou kromě referencí AI ilustrace (viz `docs/image-inventory.md`). Obrázky pro články a reference: WebP do 1280 px a vedle něj varianta `-640` (např. `foto.webp` a `foto-640.webp`), kterou použijí karty a galerie. Obrázky nahrané v administraci mají jen jednu variantu (WebP do 2400 px).

## Přesměrování ze starého webu

Zdroj je `app/redirects.php`. Po úpravě spusťte `php tools/sync-redirects.php`, přegeneruje blok v `public/.htaccess` a `docs/redirects.md`. PHP router přesměrovává také sám, statický náhled používá stránky s meta refresh.

## Měřicí kódy a Google Consent Mode v2

Kódy se zadávají v **Administrace → Měřicí kódy** (uloží se do `content/mereni.json`, ten není v Gitu): Google Analytics 4, Google Tag Manager, Google Ads, Meta Pixel, Sklik a dva vlastní kódy s volbou kategorie souhlasu. Kód je v `app/lib/tracking.php` a `public/assets/js/site.js`.

- Na začátku `<head>` se nastaví `gtag('consent', 'default', …)` se vším `denied` (`ad_storage`, `ad_user_data`, `ad_personalization`, `analytics_storage`) a `ads_data_redaction`. Dřívější volbu návštěvníka script použije hned (`consent update`), ještě před načtením tagů.
- Po volbě v liště: `gtag('consent', 'update', …)` a událost `c2000_consent_update` v `dataLayer` (pro spouštěče v GTM). Analytické = `analytics_storage`, marketingové = `ad_*`.
- **Základní režim** (výchozí): tagy Googlu se načtou až po souhlasu. **Pokročilý**: načtou se hned a do souhlasu posílají jen anonymní signály (modelování konverzí). Meta Pixel, Sklik a vlastní kódy se v obou režimech spustí až po souhlasu.
- Souhlas platí 12 měsíců (`localStorage` `c2000-consent`, `v: 2`), pak se lišta zobrazí znovu. Po odvolání souhlasu se smažou cookies `_ga*`, `_gcl_*`, `_fbp`, `_fbc` a stránka se načte znovu.
- Tabulka v Zásadách cookies se skládá podle vyplněných nástrojů (`tracking_cookie_rows()`).
- Ověření: v Google Tag Assistant (tagassistant.google.com) musí být před souhlasem vidět „Consent default: denied“ a po kliknutí na „Přijmout vše“ „Consent update: granted“.

## Zabezpečení

- **Dočasný přístup pro ukázku** je jen v lokálním `config.php` (není v Gitu). Administrace při jednoduchém hesle ukazuje varování, dokud se heslo nezmění v Nastavení. Nové heslo musí mít aspoň 10 znaků.
- Přihlášení: max. 5 chybných pokusů za 15 minut z jedné IP a 50 za hodinu celkem (proti hádání hesla z mnoha adres), každý chybný pokus se zdrží, odpověď neprozradí, jestli bylo špatně jméno, nebo heslo.
- Session jen přes HttpOnly cookie se `SameSite=Strict` (na HTTPS i `Secure`), přísný režim session, nové ID po přihlášení a každých 15 minut, odhlášení po 4 hodinách nečinnosti a nejpozději po 12 hodinách.
- CSRF token u všech formulářů administrace; akce, které něco mění (uložení, mazání, obnovení, odhlášení…), jdou jen metodou POST.
- Administrace posílá přísnou Content Security Policy (jen vlastní skripty a styly) a nejde vložit do rámu.
- Web: HTTPS + HSTS, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, bez výpisu složek. Stránky posílají CSP z PHP (`public_csp()` v `app/lib/tracking.php`): skripty jen z webu a z domén měřicích nástrojů vyplněných v administraci, skript z cizí domény prohlížeč zablokuje. Při použití GTM nebo vlastního kódu s vloženým skriptem stačí HTTPS, protože ty si načítají skripty odkudkoli.
- Formuláře po chybě vracejí jen na stránku vlastního webu (žádné otevřené přesměrování).
- Bezpečnostní test (`docs/bezpecnost.md`) prošel: CSRF, akce přes GET, path traversal, XSS v textech i formátovaném textu, nahrání PHP místo fotky, obří rozlišení, polyglot obrázek, PDF s PHP, podvržení hlavičky e-mailu, otevřené přesměrování, zámek přihlášení, CSP.
- Zablokované: `app/`, `content/`, `tools/`, `docs/`, `config.php`, skryté soubory a soubory `.json`, `.md`, `.log`, `.ini`, `.bak` apod. V `uploads/` jdou jen obrázky, v `downloads/` jen PDF, nikde nejde spustit PHP.
- Nahrané fotky se přeuloží přes GD (odstraní se případný škodlivý obsah), max. 50 megapixelů (ochrana proti „zip bombě“ z obrázku). U PDF se kontroluje hlavička souboru a přípona je vždy `.pdf`. V `uploads/` a `downloads/` je PHP vypnuté i pro případ jiného nastavení serveru.
- Formuláře: honeypot, podepsaný časový token, limit 5 odeslání za 10 minut, jednořádková pole bez řídicích znaků (nejde podstrčit hlavičku e-mailu). Záznamy limitů (hash IP) se mažou po 1 dni.
- PHP chyby se návštěvníkům nezobrazují (`app/bootstrap.php`, `public/.user.ini`).
- Písma jsou na vlastním serveru (`public/assets/fonts/`), web při načtení nekontaktuje Google.

## Před spuštěním

- **Zapnutí indexace (jediná volba):** na ostré doméně nastavte v `config.php` `'demo' => false`. Do té doby je celý web `noindex` a `robots.txt` zakazuje vše. Na testovací doméně a v náhledu nechte `true`. Ke spuštění patří také: odkomentovat přesměrování na www v `public/.htaccess`, nastavit `site_url`, `mail.*` a vyplnit měřicí kódy v administraci.
- **Právní texty** (Zásady ochrany osobních údajů, Zásady cookies) jsou doplněné podle GDPR, zákona č. 110/2019 Sb. a § 89 zákona o elektronických komunikacích, údaje o firmě podle obchodního rejstříku. Klient nebo právník by měl zkontrolovat lhůty uložení a seznam dodavatelů (hosting, e-mail, účetní). Upravují se v administraci, šablona `app/templates/pages/pravni.php`.
- **Dočasný přístup** do administrace vyměnit za vlastní heslo klienta.
- **Cookies:** souhlas se ukládá do prohlížeče (`c2000-consent`) a vyvolá událost `c2000-consent` (viz Měřicí kódy).
