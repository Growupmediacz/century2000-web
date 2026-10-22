# Century 2000 – předloha pro přenos do Lovable

Vykreslený web (statický export z PHP verze, větev `hero-loga-cms` v repu Growupmediacz/century2000-web).
Každá stránka = `<cesta>/index.html`. Vzhled, texty, obrázky a chování musí po převodu odpovídat 1:1.

- `assets/css/` – nejdřív `assets/fonts/fonts.css`, pak base, components, pages, obsah, animace (pořadí podle `<head>` stránek)
- `assets/js/site.js` – chování: menu (mega menu Služby, mobilní menu), FAQ akordeony, cookie lišta + Google Consent Mode v2, načítání měřicích kódů po souhlasu, validace formulářů, přesměrování starých kotev (#kontakt…)
- `assets/js/animace.js` – animace při posunu, parallax hero, ukazatel posunu
- `assets/fotky`, `assets/foto`, `assets/clanky`, `assets/realizace`, `assets/reference-loga`, `assets/ikony`, `assets/og`, `assets/logo`, favicony
- `downloads/vzorkovniky/*.pdf` – vzorkovníky ke stažení
- `redirects.json` – staré adresy (Joomla) → nové, 301
- `sitemap.xml`, `robots.txt` – vzor (doména https://www.century2000.cz)

Formuláře: poptávka (service, name*, email*, phone, company, message*, příloha max. 10 MB: pdf, jpg, png, webp, heic, doc(x), xls(x), dwg, dxf) a kariéra (position, name*, phone*, email, about). Ochrana: honeypot pole `web`, časový token (min. 3 s), limit 5 odeslání / 10 min / IP. Po odeslání přesměrování na `/dekujeme/` resp. `/dekujeme-kariera/`. E-mail na info@century2000.cz s Reply-To odesílatele.
