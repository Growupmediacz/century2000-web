<div data-c="CookieLista" data-if="visible">
  <div class="cookie-bar__panel" role="region" aria-label="Cookies">
    <div data-if="inSettings" hidden>
      <div class="container cookie-bar__settings">
        <div class="cookie-bar__switches">
          <div class="cookie-bar__switch-row">
            <span><strong class="cookie-bar__switch-name">Nezbytné</strong> <span class="cookie-bar__switch-note">(vždy aktivní)</span></span>
            <span class="cookie-bar__switch--locked" role="switch" aria-checked="true" aria-disabled="true" aria-label="Nezbytné cookies"><span class="cookie-bar__track--on"><span class="cookie-bar__knob--on"></span></span></span>
          </div>
          <div class="cookie-bar__switch-row">
            <span><strong class="cookie-bar__switch-name">Analytické</strong> – pomáhají nám zjistit, jak web používáte</span>
            <button class="cookie-bar__switch" type="button" role="switch" aria-checked="false" aria-label="Analytické cookies" data-on-click="toggleA"><span class="cookie-bar__track"><span class="cookie-bar__knob"></span></span></button>
          </div>
          <div class="cookie-bar__switch-row">
            <span><strong class="cookie-bar__switch-name">Marketingové</strong> – umožňují zobrazit relevantní reklamu</span>
            <button class="cookie-bar__switch" type="button" role="switch" aria-checked="false" aria-label="Marketingové cookies" data-on-click="toggleM"><span class="cookie-bar__track"><span class="cookie-bar__knob"></span></span></button>
          </div>
        </div>
      </div>
    </div>
    <div class="show-from-900">
      <div class="container cookie-bar__bar">
        <p class="text cookie-bar__text"><strong class="serif cookie-bar__title">Cookies</strong>Používáme nezbytné cookies pro fungování webu. Analytické a marketingové cookies zapneme jen s vaším souhlasem. <a class="cookie-bar__link" href="/cookies/">Více o cookies</a></p>
        <div data-if="notSettings">
          <div class="cookie-bar__actions">
            <button class="btn-secondary cookie-bar__btn" type="button" data-on-click="close">Přijmout vše</button>
            <button class="btn-secondary cookie-bar__btn" type="button" data-on-click="close">Odmítnout</button>
            <button class="btn-secondary cookie-bar__btn" type="button" data-on-click="openSettings">Nastavení</button>
          </div>
        </div>
        <div data-if="inSettings" hidden>
          <button class="btn-primary cookie-bar__save" type="button" data-on-click="close">Uložit volbu</button>
        </div>
      </div>
    </div>
    <div class="show-below-900">
      <div class="cookie-bar__bar--mobile">
        <p class="text cookie-bar__text--mobile"><strong class="cookie-bar__title--mobile">Cookies</strong>Používáme nezbytné cookies pro fungování webu. Analytické a marketingové cookies zapneme jen s vaším souhlasem. <a class="cookie-bar__link" href="/cookies/">Více o cookies</a></p>
        <div data-if="notSettings">
          <div class="cookie-bar__actions--mobile">
            <button class="cookie-bar__btn--mobile" type="button" data-on-click="close">Přijmout vše</button>
            <button class="cookie-bar__btn--mobile" type="button" data-on-click="close">Odmítnout</button>
            <button class="cookie-bar__btn--mobile" type="button" data-on-click="openSettings">Nastavení</button>
          </div>
        </div>
        <div data-if="inSettings" hidden>
          <button class="btn-primary cookie-bar__save--mobile" type="button" data-on-click="close">Uložit volbu</button>
        </div>
      </div>
    </div>
  </div>
</div>
