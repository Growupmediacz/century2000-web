# Bezpečnostní kontrola (22. 10. 2026)

Kontrola kódu a útoky proti lokální kopii webu (PHP 8.5, vývojový server). Pravidla v `.htaccess` (blokace souborů, HTTPS, hlavičky) vývojový server nečte, ty je potřeba ověřit po nahrání na hosting (viz níže).

## Opravené nálezy

| Nález | Riziko | Oprava |
|---|---|---|
| Po chybě ve formuláři šlo přes hlavičku Referer (`//cizi-web.cz`) přesměrovat návštěvníka na cizí web | phishing s adresou century2000.cz | návrat jen na místní cestu (`form_back_url()`) |
| Odhlášení a obnovení verze šlo spustit obyčejným odkazem (GET) | CSRF | akce, které něco mění, jen přes POST s CSRF tokenem |
| Fotka s obrovským rozlišením mohla při zpracování vyčerpat paměť | výpadek administrace | limit 50 megapixelů před dekódováním |
| Hádání hesla z mnoha IP adres obcházelo limit na jednu IP | prolomení hesla | navíc limit 50 chybných pokusů za hodinu celkem, zdržení po chybě |
| Session platila neomezeně dlouho, pokud se používala | zneužití ukradené session | max. 12 hodin, nové ID každých 15 minut |
| Na webu šlo načíst skript z libovolné domény | XSS přes cizí skript | CSP se seznamem domén měřicích nástrojů |
| Jednořádková pole formuláře šla do předmětu e-mailu i s novým řádkem | podvržení hlavičky e-mailu | řídicí znaky se odstraní (opraveno v předchozí části) |

## Test útoků (vše prošlo)

CSRF bez tokenu (400) · 7 akcí přes GET nic neprovede · path traversal v `?page=` (`../config`, `%2F`, `%00`) · XSS v textu, popisu obrázku a odkazu tlačítka (`javascript:`) · XSS ve formátovaném textu (`onerror`, `onload`, `onclick`, `javascript:` i se skrytým tabulátorem, `<svg>`, `<iframe>`) · PHP soubor nahraný jako fotka · obrázek 30 000 × 30 000 px · polyglot PNG s PHP kódem (přeuložen do WebP bez kódu) · PDF s PHP kódem a příponou `.php` (uloženo jako `.pdf`) · otevřené přesměrování z formuláře · `\r\nBcc:` ve jméně a službě · CSP na webu i v administraci, cizí skript zablokován, GA4 / Google Ads / Meta Pixel fungují · zámek po 5 chybných heslech (ani správné heslo během zámku neprojde).

## Po nahrání na hosting ověřit

Otevřít v prohlížeči (všechno musí vrátit chybu 403 nebo 404):

- `/app/bootstrap.php`, `/content/global.json`, `/content/.runtime/secret`, `/config.php` (pokud je vše ve `www/`)
- `/uploads/README.md`, `/.user.ini`, `/.htaccess`
- `http://…` se musí přesměrovat na `https://…`
- hlavičky (např. securityheaders.com): `Strict-Transport-Security`, `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`

## Co zůstává na provozovateli

- **Heslo:** dočasné heslo pro ukázku vyměnit za vlastní (min. 10 znaků), nesdílet přístup více lidem.
- **Vlastní měřicí kódy** v administraci se spouštějí na webu, proto vkládat jen kódy od důvěryhodných dodavatelů. Kdo má přístup do administrace, může na web vložit skript.
- **Přílohy z poptávkového formuláře** (Word, Excel, výkresy) chodí e-mailem; otevírat je s aktuálním antivirem a s vypnutými makry.
- **Aktualizace PHP** na hostingu (podporovaná verze 8.1+) a zálohy hostingu.
- Dvoufázové přihlášení administrace není; pokud by do ní mělo přístup víc lidí, doporučuji ho doplnit.
