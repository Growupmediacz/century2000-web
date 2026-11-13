# Návrh administrace (CMS)

Statické návrhy obrazovek vygenerované v Higgsfieldu (GPT Image 2.5), 22. 10. 2026. Slouží ke schválení klientem, nejde o screenshoty hotové administrace. Texty, loga hotelů a fotky v náhledech jsou ilustrační.

| Soubor | Obrazovka | Stav v kódu |
|---|---|---|
| `1-prehled.jpg` | Přehled: rychlé akce, naposledy upravené, stav webu | hotovo |
| `2-uvodni-blok.jpg` | Úvodní stránka, hero: texty, tlačítka, ozdobný nápis, fotka, 4 přednosti | hotovo, bez živého náhledu vedle formuláře (viz níže) |
| `3-reference.jpg` | Reference: pořadí, logo, přepínač „na úvodní stránce“ | hotovo; detail se otevírá na vlastní stránce, ne v postranním panelu |
| `4-clanek.jpg` | Článek z bloků: odstavec, obrázek, rámeček, přidat/posunout/smazat | hotovo; datum, služby, SEO jsou nad bloky, ne v pravém sloupci |
| `5-vzorkovniky-nastaveni.jpg` | Vzorkovníky (PDF) a změna hesla | hotovo; heslo je v samostatné položce Nastavení |

Rozdíly proti návrhu (záměrně jednodušší, ať administrace běží na běžném PHP hostingu bez knihoven):

- **Živý náhled** vedle formuláře není. Změny se ukáží po uložení odkazem „Zobrazit stránku ↗“, předchozí verzi vrátí „Historie verzí“.
- **Řazení** šipkami ↑ ↓ místo tažení myší (funguje i na telefonu).
- Přednosti v hero mají pevné ikony, upravuje se text; prázdný text přednost skryje.
