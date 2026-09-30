# Century 2000 – web

Statický web (HTML, CSS, JavaScript) podle návrhu z Claude Design. Nepotřebuje databázi ani serverový jazyk. Hotový web je ve složce `site/` a nahrává se na jakýkoli hosting.

## Jak pracovat

```bash
python3 build.py          # sestaví src/ → site/
python3 build.py serve    # sestaví a spustí náhled na http://localhost:8000
```

Upravuje se jen `src/`. Složka `site/` se při každém buildu vytvoří znovu.

## Struktura

```
src/
  pages/        jedna stránka = jeden soubor (obsah + metadata v úvodním komentáři <!--page {...} -->)
  partials/     hlavička, patička, cookie lišta – vkládají se přes <!-- @include header -->
  assets/
    css/base.css           barvy a písma (proměnné z design systému), základní styly
    css/components.css     sdílené prvky (.btn-primary, .title-section, .eyebrow, .container…)
                           a komponenty (.site-header, .site-footer, .cookie-bar, .service-card, .inquiry)
    css/pages.css          sekce stránek, pojmenované podle sekcí v návrhu (.index-hero, .service-faq…)
    css/design-system.css  jen pro interní stránku design systému
    js/site.js             menu, FAQ, cookie lišta, validace formulářů
    fotky/, logo/, reference-loga/
build.py        build, SEO výstupy a náhledový server
handoff/        původní návrh z Claude Design (jen pro referenci)
```

V `src` se odkazy píšou od kořene webu (`/kontakt/`, `/assets/...`). Build je převede na relativní cesty, takže web funguje v kořeni domény i v podsložce.

## SEO a technika

- čisté adresy (`/kontakt/`, `/hotelovy-textil/`…)
- `<title>`, description, canonical, Open Graph a Twitter karta na každé stránce
- strukturovaná data: firma (LocalBusiness) na úvodu, Kontaktu a O nás, drobečková navigace na podstránkách
- `sitemap.xml` a `robots.txt`
- `noindex` pro děkovací stránky, 404, `/nahled/` a `/design-system/` (nejsou ani v sitemapě)
- `.htaccess` pro Apache: vlastní stránka 404, cache a komprese
- obrázky pod první sekcí se načítají líně, `aria-current` u aktivní položky menu

Doménu (`https://www.century2000.cz`) a údaje o firmě nastavíte na začátku `build.py`.

## Náhled pro klienta (GitHub Pages)

Každý push do větve `main` spustí `.github/workflows/pages.yml`: ten sestaví web v ukázkovém režimu
(`--demo` = skrytý před vyhledávači) a zveřejní ho na https://growupmediacz.github.io/century2000-web/.

- `/nahled/` – přehled všech stránek na desktopu a mobilu vedle sebe
- ostrý web pro hosting sestavíte bez přepínačů: `python3 build.py` a nahrajete obsah složky `site/`

## Před spuštěním ostrého webu

- **Formuláře** se zatím jen zvalidují a přesměrují na děkovací stránku. Pro skutečné odesílání doplňte formuláři atribut `action` (PHP skript, Formspree, Netlify Forms…).
- **Značky `[DOPLNIT: …]`** v textech – údaje k potvrzení klientem (adresa, doba výroby, montáž…). Adresa je i ve strukturovaných datech v `build.py`.
- **Cookies:** souhlas se ukládá do `localStorage` (`c2000-consent`) a vyvolá událost `c2000-consent`. Na ni se napojí analytika, až bude potřeba.
