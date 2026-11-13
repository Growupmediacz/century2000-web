#!/usr/bin/env bash
# Builds the Hostinger deploy tree (contents of public_html) into the given folder (default: hostinger/).
#
# Hostinger's Git deploy replaces the whole public_html on every deploy (files not in the branch are deleted).
# So the client's data never lives there: the app keeps content/, uploads, PDF catalogues and config.php in
# web-data/ next to public_html, seeds it from _seed/ on the first run (only what is missing) and links
# uploads/ and downloads/vzorkovniky/ back into the web root (app/bootstrap.php).
set -euo pipefail
cd "$(dirname "$0")/.."
out="${1:-hostinger}"
rm -rf "$out"
mkdir -p "$out/_seed/uploads"

cp -a public/. "$out/"
rm -rf "$out/_dev"
# client files: only the initial set, as seed
cp public/uploads/.htaccess "$out/_seed/uploads/.htaccess"
rm -rf "$out/uploads"
mv "$out/downloads/vzorkovniky" "$out/_seed/vzorkovniky"
cp public/downloads/.htaccess "$out/_seed/vzorkovniky/.htaccess"

cp -a app "$out/app"
cp config.example.php "$out/"
cp -a content "$out/_seed/content"
rm -rf "$out/_seed/content/.runtime" "$out/_seed/content/backups" "$out/_seed/content/mereni.json"

# safety checks
test ! -e "$out/config.php"
test ! -e "$out/content" && test ! -e "$out/uploads" && test ! -e "$out/downloads/vzorkovniky"
test -f "$out/.htaccess" && test -f "$out/downloads/.htaccess" && test -f "$out/_seed/uploads/.htaccess"
echo "Hostinger build: $out ($(find "$out" -type f | wc -l | tr -d ' ') files)"
