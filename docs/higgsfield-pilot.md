# Higgsfield: pilot 5 vzorků (9. 10. 2026)

Cíl: ověřit, jestli lze fotky z roku 2012–2015 sjednotit a zvětšit bez zásahu do látek. Pilot stál asi 6 kreditů. **Žádný upravený soubor není v repozitáři**, vzorky čekají na schválení. Porovnání před/po: `century2000-zastavka-2/vzorek-N-pred-po.jpg` (mimo repo, ve složce session).

| # | Fotka | Nástroj | Výsledek |
|---|---|---|---|
| 1 | Four Seasons `Obraz0737` (mobilní snímek) | upscale 2K | **vhodné.** 960×1280 → 2160×2880, vzory brokátu i barvy beze změny, čistší hrany |
| 2 | Hotel Aqua `Aqua1` | generativní retuš (GPT Image 2.5) | **nevhodné.** Změnila barvy a okraj přehozu, tvar lampy a vzor polštářů. Porušuje pravidlo „nesahat na látky“ |
| 3 | Corinthia Tower | upscale 2K | **vhodné.** 1280×960 → 2880×2160, přehoz i závěsy beze změny. Jas zůstává tmavý |
| 4 | Le Palais `balonove-zavesy-3` | generativní retuš (světlo) | **s výhradou.** Scéna je věrná, ale model přepsal strop (z teplé na bílou) a překreslil záhyby závěsu |
| 5 | Ostatní realizace `DSC01041` | generativní retuš (razítko) | **použitelné.** Datum zmizelo, závěs a rostlina zůstaly, jemná struktura látky je mírně překreslená |

## Doporučení

1. **Zvětšení (upscale)** je spolehlivé a látky nemění. Navrhuji ho pro všechny hlavní fotky referencí, kde dnes zobrazujeme 800–1280 px (asi 8 hlavních + hero fotky).
2. **Světlo a bílá** udělat bez generativní AI, klasickými úpravami (úrovně, vyvážení bílé), aby látky zůstaly neměnné. Generativní retuš nepoužívat u fotek, ze kterých si zákazník vybírá materiál (přehozy, závěsy, polštáře).
3. **Odstranění datumového razítka** (fotky „Ostatní realizace“) povolit jen po schválení konkrétní fotky, je to jediný případ, kdy retuš dopadla dobře.
4. Žádné generování realizací „z nuly“.

Po schválení doporučení provedu dávku (upscale vybraných fotek, ostatní klasické úpravy) a doplním ji do tohoto PR.

## Aktualizace 9. 10. 2026

Klient se rozhodl, že staré fotky do konceptu nezapadají. Nové ilustrace jsou vygenerované od nuly (viz `docs/image-inventory.md`, sekce 2). Reference zůstávají na skutečných fotkách, jejich případný upscale zůstává možností.
