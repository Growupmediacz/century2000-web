#!/usr/bin/env python3
"""Century 2000 – static site build (Python 3, no dependencies).

    python3 build.py          # build src/ -> site/
    python3 build.py serve    # build and preview on http://localhost:8000
    python3 build.py --demo --base /century2000-web
                              # client preview (GitHub Pages): hidden from search engines,
                              # served from a subfolder

src/pages/*.html     page body + JSON front matter in a leading <!--page {...} --> comment
src/partials/*.html  shared blocks, inserted with <!-- @include name -->
src/assets/          CSS, JS, images (copied as-is)

In src, internal links and assets use root paths (/kontakt/, /assets/...). The build rewrites them
to relative paths, so the output works at a domain root or in a subfolder.
"""
import datetime
import html
import json
import os
import re
import shutil
import sys

# ---------------------------------------------------------------- configuration
SITE_URL = 'https://www.century2000.cz'   # production domain (canonical URLs, sitemap, Open Graph)
SITE_NAME = 'Century 2000'
DEFAULT_IMAGE = '/assets/fotky/hero-sici-dilna.webp'
NOINDEX = {'/404.html', '/dekujeme/', '/dekujeme-kariera/', '/design-system/', '/nahled/'}

# Breadcrumb parents for structured data (visible breadcrumbs are part of the page markup).
SERVICES = {'/bytovy-textil-na-miru/', '/hotelovy-textil/', '/strojni-prosivani/', '/matracove-chranice-a-potahy/', '/latky-a-metraz/'}

ORGANIZATION = {
    '@context': 'https://schema.org',
    '@type': 'LocalBusiness',
    '@id': SITE_URL + '/#firma',
    'name': 'CENTURY 2000 s.r.o.',
    'description': 'Zakázková výroba bytového a hotelového textilu, strojní prošívání a prodej látek ve Zruči nad Sázavou.',
    'url': SITE_URL + '/',
    'logo': SITE_URL + '/assets/logo/century2000-logo.svg',
    'image': SITE_URL + DEFAULT_IMAGE,
    'telephone': '+420603287803',
    'email': 'info@century2000.cz',
    'foundingDate': '2000',
    'vatID': 'CZ26141116',
    'identifier': 'IČ 26141116',
    'address': {  # TODO: address marked [DOPLNIT: potvrdit adresu] in the design
        '@type': 'PostalAddress',
        'streetAddress': 'Okružní 600',
        'postalCode': '285 22',
        'addressLocality': 'Zruč nad Sázavou',
        'addressCountry': 'CZ',
    },
    'openingHoursSpecification': [{
        '@type': 'OpeningHoursSpecification',
        'dayOfWeek': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        'opens': '07:00', 'closes': '15:30',
    }],
}

# Set from the command line (see bottom of file).
DEMO = False      # preview build: every page noindex, robots.txt disallows everything
BASE_PATH = ''    # site served from a subfolder, e.g. '/century2000-web' on GitHub Pages

ROOT = os.path.dirname(os.path.abspath(__file__))
SRC = os.path.join(ROOT, 'src')
OUT = os.path.join(ROOT, 'site')


# ---------------------------------------------------------------- helpers
def read(path):
    with open(path, encoding='utf-8') as f:
        return f.read()


def write(path, text):
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, 'w', encoding='utf-8') as f:
        f.write(text)


def load_page(path):
    m = re.match(r'<!--page\s*(\{.*?\})\s*-->\n?', read(path), re.S)
    if not m:
        raise SystemExit(f'{path}: missing <!--page {{...}} --> front matter')
    meta = json.loads(m.group(1))
    return meta, read(path)[m.end():]


def include(body, partials):
    def repl(m):
        name = m.group(1)
        if name not in partials:
            raise SystemExit(f'unknown partial: {name}')
        return partials[name].rstrip('\n')
    return re.sub(r'<!-- @include ([\w-]+) -->', repl, body)


def mark_current(body, path):
    """aria-current="page" on header/footer links pointing to this page."""
    return re.sub(rf'(<a\b[^>]*\shref="{re.escape(path)}")', r'\1 aria-current="page"', body)


def relativize(text, path, absolute):
    """Rewrite root paths (/kontakt/, /assets/...) in href/src/data-thanks to relative ones."""
    if absolute:  # e.g. 404.html, served at any URL depth
        if not BASE_PATH:
            return text
        return re.sub(r'\b(href|src|data-thanks)="/(?!/)', lambda m: f'{m.group(1)}="{BASE_PATH}/', text)
    depth = 0 if path == '/' else path.strip('/').count('/') + 1
    prefix = '../' * depth

    def repl(m):
        attr, url = m.group(1), m.group(2)
        if url.startswith('//'):
            return m.group(0)
        rel = prefix + url[1:]
        return f'{attr}="{rel or "./"}"'
    return re.sub(r'\b(href|src|data-thanks)="(/[^"]*)"', repl, text)


def breadcrumb_ld(meta):
    path = meta['path']
    if path == '/' or path in NOINDEX:
        return None
    items = [('Úvod', '/')]
    if path in SERVICES:
        items.append(('Služby', '/#co-sijeme'))
    items.append((meta.get('name') or meta['title'].split(' | ')[0].split(' – ')[0], path))
    return {
        '@context': 'https://schema.org', '@type': 'BreadcrumbList',
        'itemListElement': [{'@type': 'ListItem', 'position': i + 1, 'name': n, 'item': SITE_URL + u}
                            for i, (n, u) in enumerate(items)],
    }


def head(meta):
    path, title, desc = meta['path'], meta['title'], meta.get('description', '')
    url = SITE_URL + path
    image = SITE_URL + meta.get('image', DEFAULT_IMAGE)
    e = lambda s: html.escape(s, quote=True)
    lines = [
        '<meta charset="utf-8">',
        '<meta name="viewport" content="width=device-width, initial-scale=1">',
        f'<title>{e(title)}</title>',
    ]
    if desc:
        lines.append(f'<meta name="description" content="{e(desc)}">')
    if path in NOINDEX or DEMO:
        lines.append('<meta name="robots" content="noindex, follow">')
    if path not in NOINDEX:
        lines += [
            f'<link rel="canonical" href="{e(url)}">',
            '<meta property="og:type" content="website">',
            '<meta property="og:locale" content="cs_CZ">',
            f'<meta property="og:site_name" content="{SITE_NAME}">',
            f'<meta property="og:title" content="{e(title)}">',
            f'<meta property="og:description" content="{e(desc)}">',
            f'<meta property="og:url" content="{e(url)}">',
            f'<meta property="og:image" content="{e(image)}">',
            '<meta name="twitter:card" content="summary_large_image">',
        ]
    lines += [
        '<meta name="theme-color" content="#F8F5F0">',
        '<link rel="icon" type="image/png" href="/assets/favicon-32x32.png">',
        '<link rel="preconnect" href="https://fonts.googleapis.com">',
        '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>',
        '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&amp;family=Parisienne&amp;family=Playfair+Display:ital,wght@0,500;0,600;1,500&amp;display=swap">',
    ]
    for css in ['base', 'components', 'pages'] + meta.get('css', []):
        lines.append(f'<link rel="stylesheet" href="/assets/css/{css}.css">')
    lines.append('<script src="/assets/js/site.js" defer></script>')
    if path not in NOINDEX:
        for data in filter(None, [ORGANIZATION if path in ('/', '/kontakt/', '/o-nas/') else None, breadcrumb_ld(meta)]):
            lines.append('<script type="application/ld+json">' + json.dumps(data, ensure_ascii=False) + '</script>')
    return '\n'.join('  ' + l for l in lines)


def render(meta, body, partials):
    body = include(body, partials)
    body = mark_current(body, meta['path'])
    doc = f'<!DOCTYPE html>\n<html lang="cs">\n<head>\n{head(meta)}\n</head>\n<body>\n{body.strip()}\n</body>\n</html>\n'
    return relativize(doc, meta['path'], meta.get('absolute', False))


def out_file(path):
    if path.endswith('.html'):
        return os.path.join(OUT, path.lstrip('/'))
    return os.path.join(OUT, path.strip('/'), 'index.html')


# ---------------------------------------------------------------- build
def build():
    if os.path.isdir(OUT):
        shutil.rmtree(OUT)
    shutil.copytree(os.path.join(SRC, 'assets'), os.path.join(OUT, 'assets'))

    partials = {f[:-5]: read(os.path.join(SRC, 'partials', f)) for f in sorted(os.listdir(os.path.join(SRC, 'partials'))) if f.endswith('.html')}
    pages = []
    for f in sorted(os.listdir(os.path.join(SRC, 'pages'))):
        if not f.endswith('.html'):
            continue
        meta, body = load_page(os.path.join(SRC, 'pages', f))
        write(out_file(meta['path']), render(meta, body, partials))
        pages.append(meta)

    today = datetime.date.today().isoformat()
    urls = sorted((m['path'] for m in pages if m['path'] not in NOINDEX), key=lambda p: (p != '/', p))
    write(os.path.join(OUT, 'sitemap.xml'),
          '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'
          + ''.join(f'  <url><loc>{SITE_URL}{u}</loc><lastmod>{today}</lastmod></url>\n' for u in urls)
          + '</urlset>\n')
    if DEMO:
        write(os.path.join(OUT, 'robots.txt'), 'User-agent: *\nDisallow: /\n')
    else:
        write(os.path.join(OUT, 'robots.txt'), f'User-agent: *\nAllow: /\n\nSitemap: {SITE_URL}/sitemap.xml\n')
    write(os.path.join(OUT, '.htaccess'), HTACCESS)
    print(f'built {len(pages)} pages -> {os.path.relpath(OUT, ROOT)}/ ({len(urls)} in sitemap)')


HTACCESS = """# Apache (most Czech web hosts). Other hosts: set 404.html as the error page.
DirectoryIndex index.html
ErrorDocument 404 /404.html
Options -Indexes

<IfModule mod_rewrite.c>
  RewriteEngine On
  # Uncomment on production to force HTTPS and www:
  # RewriteCond %{HTTPS} off [OR]
  # RewriteCond %{HTTP_HOST} !^www\\. [NC]
  # RewriteRule ^ https://www.century2000.cz%{REQUEST_URI} [L,R=301]
</IfModule>

<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType image/svg+xml "access plus 1 year"
  ExpiresByType text/css "access plus 1 week"
  ExpiresByType application/javascript "access plus 1 week"
</IfModule>

<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript image/svg+xml application/xml text/plain
</IfModule>
"""


def serve(port=8000):
    import http.server
    import functools

    class Handler(http.server.SimpleHTTPRequestHandler):
        def end_headers(self):
            self.send_header('Cache-Control', 'no-store')   # always show the latest build
            super().end_headers()

        def send_error(self, code, message=None, explain=None):
            if code != 404:
                return super().send_error(code, message, explain)
            body = read(os.path.join(OUT, '404.html')).encode('utf-8')   # like ErrorDocument in .htaccess
            self.send_response(404)
            self.send_header('Content-Type', 'text/html; charset=utf-8')
            self.send_header('Content-Length', str(len(body)))
            self.end_headers()
            self.wfile.write(body)

    handler = functools.partial(Handler, directory=OUT)
    print(f'preview: http://localhost:{port}/  (Ctrl+C to stop)')
    http.server.ThreadingHTTPServer(('127.0.0.1', port), handler).serve_forever()


if __name__ == '__main__':
    args = sys.argv[1:]
    DEMO = '--demo' in args
    if '--base' in args:
        BASE_PATH = '/' + args[args.index('--base') + 1].strip('/')
    build()
    if args and args[0] == 'serve':
        serve(int(args[1]) if len(args) > 1 and args[1].isdigit() else 8000)
