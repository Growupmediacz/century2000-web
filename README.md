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
4. V `public/.htaccess` odkomentujte přesměrování na HTTPS a www.

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

Čisté adresy, titulek a popis každé stránky (editovatelné), canonical, Open Graph, strukturovaná data firmy a drobečkové navigace, dynamická `sitemap.xml` a `robots.txt`, `noindex` pro děkovací stránky, 404 a interní stránky (`/nahled/`, `/design-system/`). Doménu a údaje o firmě nastavíte v `config.php` (`site_url`) a v `app/lib/seo.php`.

## Reference, články, vzorkovníky: jak přidat a upravit

Všechno je ve stejném systému jako ostatní stránky (JSON v `content/pages/`, úpravy v administraci):

- **Článek:** `/admin/` → *Články* → pole „Název nového článku“ → *Napsat článek*. Otevře se editor: hlavička (nadpis, perex, obrázek), bloky (odstavec `blok-N`, obrázek s popiskem `foto-N`, rámeček „Dobré vědět“ `tip-N`), související služba. Bloky se přidávají, posouvají a mažou tlačítky v editoru. Pořadí sekcí v souboru je pořadí v článku. Stejné bloky dostane každá stránka s `options.blocks: true`. V `options.related` jsou adresy souvisejících článků a v `options.service` stránky služeb, na kterých se článek nabízí jako doporučený. Adresa je `/clanky/<slug>/`, zařadí se do výpisu, sitemapy a strukturovaných dat (Article). Články jsou odkazované z patičky, ne z hlavního menu.
- **Reference (realizace):** `/admin/` → *Reference* → *Přidat realizaci*. Každá realizace má vlastní stránku `/reference/<slug>/` (hlavní fotka, co jsme šili, popis, poznámka o spolupráci, galerie). Karty na stránce Reference, seznam na úvodní stránce a na stránce Hotelový textil se plní z těchto souborů, takže jsou vždy shodné. Pořadí určuje `options.order` (v administraci šipkami), v pruhu pod úvodní fotkou a na stránce Hotelový textil se zobrazí realizace s `options.featured: true` (přepínač „Na úvodní stránce“). Logo hotelu je v sekci `logo` dané reference (`public/assets/reference-loga/`), bez loga se ukáže název hotelu.
- **Vzorkovníky:** `/admin/` → *Vzorkovníky*. PDF jsou v `public/downloads/vzorkovniky/` (složka musí mít právo zápisu), seznam (název, velikost, skrytí) je v `content/pages/vzorkovniky.json` v `options.files`.
- **Starý obsah:** texty o látkách jsou na stránce Látky a metráž v sekcích „Materiál: …“ (`blok-*`), kotvy `#blackouty`, `#zaclony` apod. používají přesměrování.

Obrázky na webu jsou kromě referencí AI ilustrace (viz `docs/image-inventory.md`). Obrázky pro články a reference: WebP do 1280 px a vedle něj varianta `-640` (např. `foto.webp` a `foto-640.webp`), kterou použijí karty a galerie. Obrázky nahrané v administraci mají jen jednu variantu (WebP do 2400 px).

## Přesměrování ze starého webu

Zdroj je `app/redirects.php`. Po úpravě spusťte `php tools/sync-redirects.php`, přegeneruje blok v `public/.htaccess` a `docs/redirects.md`. PHP router přesměrovává také sám, statický náhled používá stránky s meta refresh.

## Analytika

V `config.php` nastavte `'analytics' => ['ga4_id' => 'G-XXXXXXXXXX']` až po dodání ID od klienta. Bez ID se žádný měřicí kód nenačítá, s ID se Google Analytics načte až po souhlasu s analytickými cookies (volba je v `localStorage` pod klíčem `c2000-consent`).

## Před spuštěním

- **Zapnutí indexace (jediná volba):** na ostré doméně nastavte v `config.php` `'demo' => false`. Do té doby je celý web `noindex` a `robots.txt` zakazuje vše. Na testovací doméně a v náhledu nechte `true`. Ke spuštění patří také: odkomentovat přesměrování na HTTPS a www v `public/.htaccess`, nastavit `site_url`, `mail.*` a doplnit ID analytiky.
- **Značky `[DOPLNIT: …]`** zůstaly jen v Zásadách ochrany osobních údajů (datum účinnosti a lhůty uchování údajů, ke kontrole klientem nebo právníkem). Seznam otázek pro klienta je v popisu pull requestu. Adresa firmy je v patičce (`content/global.json`) a v `app/lib/seo.php`.
- **Cookies:** souhlas se ukládá do prohlížeče (`c2000-consent`) a vyvolá událost `c2000-consent`, na kterou se napojí analytika.
