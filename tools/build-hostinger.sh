#!/usr/bin/env bash
# Builds the Hostinger deploy tree (contents of public_html) into the given folder (default: hostinger/).
# Layout: web root files from public/ + app/ next to them. Initial content goes to _seed/ – the app copies
# it to content/ (and the PDF catalogues to downloads/vzorkovniky/) only if missing, so a Git redeploy
# never overwrites what the client changed in the admin. config.php is never part of the build.
set -euo pipefail
cd "$(dirname "$0")/.."
out="${1:-hostinger}"
rm -rf "$out"
mkdir -p "$out/_seed"

cp -a public/. "$out/"
rm -rf "$out/_dev"
# client files live only on the server
find "$out/uploads" -mindepth 1 ! -name .htaccess -exec rm -rf {} +
mv "$out/downloads/vzorkovniky" "$out/_seed/vzorkovniky"

cp -a app "$out/app"
cp config.example.php "$out/"
cp -a content "$out/_seed/content"
rm -rf "$out/_seed/content/.runtime" "$out/_seed/content/backups" "$out/_seed/content/mereni.json"

# safety checks
test ! -e "$out/config.php"
test ! -e "$out/content"
test -f "$out/.htaccess" && test -f "$out/uploads/.htaccess" && test -f "$out/downloads/.htaccess"
echo "Hostinger build: $out ($(find "$out" -type f | wc -l | tr -d ' ') files)"
