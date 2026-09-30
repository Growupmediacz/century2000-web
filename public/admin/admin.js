/* Century 2000 – administration: rich text toolbar, image preview, section switch, unsaved changes. */
(() => {
  const form = document.querySelector('[data-edit-form]');

  // Confirmation for restore buttons
  document.querySelectorAll('form[data-confirm]').forEach(f =>
    f.addEventListener('submit', e => { if (!confirm(f.dataset.confirm)) e.preventDefault(); }));

  if (!form) return;
  let dirty = false;
  const note = form.querySelector('[data-dirty-note]');
  const markDirty = () => { dirty = true; if (note) note.hidden = false; };
  form.addEventListener('input', markDirty);
  form.addEventListener('change', markDirty);
  window.addEventListener('beforeunload', e => { if (dirty) { e.preventDefault(); e.returnValue = ''; } });

  // Rich text: contenteditable area + hidden input
  form.querySelectorAll('.adm-rte').forEach(rte => {
    const area = rte.querySelector('[data-rte]');
    const input = rte.querySelector('[data-rte-input]');
    const sync = () => { input.value = area.innerHTML.trim(); };
    area.addEventListener('input', sync);
    // Paste as plain text (no styles from Word/web pages)
    area.addEventListener('paste', e => {
      e.preventDefault();
      document.execCommand('insertText', false, (e.clipboardData || window.clipboardData).getData('text/plain'));
    });
    // Enter = line break, not a new block
    area.addEventListener('keydown', e => {
      if (e.key === 'Enter') { e.preventDefault(); document.execCommand('insertLineBreak'); }
    });
    rte.querySelectorAll('[data-cmd]').forEach(btn => btn.addEventListener('mousedown', e => {
      e.preventDefault();
      area.focus();
      const cmd = btn.dataset.cmd;
      if (cmd === 'link') {
        const href = prompt('Adresa odkazu (např. https://…, /kontakt/, mailto:…, tel:…)', 'https://');
        if (!href || href === 'https://') return;
        document.execCommand('createLink', false, href);
      } else {
        document.execCommand(cmd);
      }
      sync();
      markDirty();
    }));
  });

  // Image preview before saving
  form.querySelectorAll('[data-image-input]').forEach(input => input.addEventListener('change', () => {
    const file = input.files && input.files[0];
    if (!file) return;
    const box = input.closest('.adm-image');
    box.querySelector('[data-preview]').src = URL.createObjectURL(file);
    box.querySelector('[data-file-name]').textContent = file.name + ' – nahraje se po uložení';
  }));

  // Section switch: badge + dimmed card
  form.querySelectorAll('[data-visible-toggle]').forEach(cb => cb.addEventListener('change', () => {
    const section = cb.closest('.adm-section');
    section.classList.toggle('is-hidden', !cb.checked);
    section.querySelector('[data-hidden-badge]').hidden = cb.checked;
  }));

  // Character counters for SEO fields
  form.querySelectorAll('[data-count]').forEach(el => {
    const label = el.closest('.adm-field').querySelector('span');
    const counter = document.createElement('span');
    counter.className = 'adm-count';
    label.append(' ', counter);
    const update = () => {
      const n = el.value.length, max = +el.dataset.count;
      counter.textContent = `${n} znaků (doporučeno do ${max})`;
      counter.classList.toggle('is-over', n > max);
    };
    el.addEventListener('input', update);
    update();
  });

  form.addEventListener('submit', () => {
    form.querySelectorAll('.adm-rte').forEach(rte => { rte.querySelector('[data-rte-input]').value = rte.querySelector('[data-rte]').innerHTML.trim(); });
    dirty = false;
  });
})();
