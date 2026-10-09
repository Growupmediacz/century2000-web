# Přesměrování ze starého webu (Joomla, záloha 19. 2. 2024)

Zdroj: `app/redirects.php`. Po úpravě spusťte `php tools/sync-redirects.php`, aktualizuje se tento soubor i blok v `public/.htaccess`.
Přesměrování (301) obsluhuje i PHP router, takže fungují i bez `.htaccess`. Statický náhled na GitHub Pages je nahrazuje stránkami s meta refresh.

| Starý odkaz | Nový odkaz |
|---|---|
| `/index.php` | `/` (jen PHP router) |
| `/siti-bytoveho-textilu` | `/bytovy-textil-na-miru/` |
| `/siti-bytoveho-textilu/okenni-dekorace` | `/bytovy-textil-na-miru/` |
| `/siti-bytoveho-textilu/potahy-na-zidle` | `/bytovy-textil-na-miru/` |
| `/siti-bytoveho-textilu/prehozy-a-polstarky` | `/bytovy-textil-na-miru/` |
| `/siti-bytoveho-textilu/rautove-sukne` | `/hotelovy-textil/` |
| `/siti-bytoveho-textilu/vyroba-textilnich-vzorkovnic` | `/vzorkovniky/` |
| `/siti-potahu-na-matrace` | `/matracove-chranice-a-potahy/` |
| `/siti-potahu-na-matrace/matracove-chranice` | `/matracove-chranice-a-potahy/` |
| `/siti-potahu-na-matrace/potahy-na-matrace-a-vyplne-polstaru` | `/matracove-chranice-a-potahy/` |
| `/prosev-materialu` | `/strojni-prosivani/` |
| `/prodej-metraze` | `/latky-a-metraz/` |
| `/prodej-metraze/zaclony` | `/latky-a-metraz/#zaclony` |
| `/prodej-metraze/ubrusoviny` | `/latky-a-metraz/#ubrusoviny` |
| `/prodej-metraze/blackouty` | `/latky-a-metraz/#blackouty` |
| `/prodej-metraze/dimouty` | `/latky-a-metraz/#dimouty` |
| `/prodej-metraze/dekoracni-latky` | `/latky-a-metraz/#dekoracni-latky` |
| `/prodej-metraze/dekoracni-latky-s-nehorlavou-upravou` | `/latky-a-metraz/#nehorlave-latky` |
| `/prodej-metraze/polyesterova-rouna-a-netkane-textilie` | `/latky-a-metraz/#rouna` |
| `/prodej-metraze/materialy-pro-vyrobu-potahu-na-matrace` | `/latky-a-metraz/#materialy-na-potahy` |
| `/prodej-metraze/maloobchodni-prodej` | `/latky-a-metraz/` |
| `/produkty/latky-na-ubrusy` | `/clanky/latky-na-ubrusy-a-prostirani/` |
| `/e-shop` | `https://century2000-cz.webnode.cz/` |

## Adresy, které se nemění

Tyto adresy existují i v novém webu, chybějící lomítko na konci doplní router přesměrováním 301:

`/o-nas`, `/kontakt`, `/reference`, `/vzorkovniky` a `/reference/<alias>` (hotel-four-season-praha, hotel-le-palais-praha, hotel-corinthia-tower-praha, hotel-1-republika-praha, palac-u-kocku-praha, hotel-aqua-praha-pruhonice, hotel-international-brno, ostatni-realizace).

## Poznámky

- Tvary adres vychází z aliasů menu a článků v dumpu (`ij7hd_menu`, `ij7hd_content`) a z přístupových logů 15.–18. 2. 2024. Tabulka `ij7hd_redirect_links` (Joomla) je prázdná.
- `/prodej-metraze/maloobchodni-prodej` byl nepublikovaný, přesměrování vede na Látky a metráž.
- Statické soubory ze starého webu (`/images/...`, `/media/com_dropfiles/...`) se nepřenášejí. Staré PDF mají nové adresy v `/downloads/vzorkovniky/`.
