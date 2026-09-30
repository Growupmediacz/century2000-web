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
2. Složky `content/` a `www/uploads/` musí mít právo zápisu (PHP do nich ukládá).
3. V `config.php` nastavte `mail.from` (schránka na doméně webu, např. `web@century2000.cz`) a `mail.to`.
   `transport => 'mail'` funguje na Webglobe bez dalšího nastavení. Spolehlivější je `smtp` s přihlášením ke schránce.
4. V `public/.htaccess` odkomentujte přesměrování na HTTPS a www.

**Při dalších nasazeních nepřepisujte `content/`, `www/uploads/` ani `config.php`.** Jsou v nich úpravy klienta a hesla.

## Náhled pro klienta (GitHub Pages)

Každý push do `main` spustí `.github/workflows/pages.yml`. Ten web vyexportuje do statického HTML (`php tools/export-static.php --demo`) a zveřejní ho na https://growupmediacz.github.io/century2000-web/ (skrytý před vyhledávači).
Náhled ukazuje obsah z Gitu, ne úpravy z administrace na ostrém webu. Formuláře v něm jen přesměrují na děkovací stránku.

## Administrace

- přihlášení jménem a heslem (heslo nastaví `php tools/set-password.php`), po 5 chybných pokusech se přihlašování na 15 minut zablokuje
- stránky rozdělené na sekce: texty, formátovaný text (tučně, kurzíva, odkazy), obrázky s popisem a přepínač **Zobrazit sekci na webu**
- nahrané fotky se automaticky otočí, zmenší na max. 2400 px a převedou do WebP
- před každým uložením se uloží předchozí verze. **Historie verzí** umožní obnovit kteroukoli z posledních 30.

## SEO

Čisté adresy, titulek a popis každé stránky (editovatelné), canonical, Open Graph, strukturovaná data firmy a drobečkové navigace, dynamická `sitemap.xml` a `robots.txt`, `noindex` pro děkovací stránky, 404 a interní stránky (`/nahled/`, `/design-system/`). Doménu a údaje o firmě nastavíte v `config.php` (`site_url`) a v `app/lib/seo.php`.

## Před spuštěním

- **Značky `[DOPLNIT: …]`** v textech – klient je doplní v administraci. Adresa firmy je i v `app/lib/seo.php`.
- **Cookies:** souhlas se ukládá do prohlížeče (`c2000-consent`) a vyvolá událost `c2000-consent`, na kterou se napojí analytika.
