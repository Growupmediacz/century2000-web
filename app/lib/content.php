<?php
/*
 * Content storage: one JSON file per page in content/pages/, shared content (footer) in content/global.json.
 *
 * Page JSON:
 *   path, name, editable, meta {title, description}, options {image, css, absolute},
 *   sections [ {key, label, hideable, visible, fields [ {key, type: text|rich|image, label, value} ]} ]
 */
declare(strict_types=1);

const BACKUPS_KEEP = 30;

function content_file(string $name): string
{
    if (!preg_match('/^[a-z0-9-]+$/', $name)) {
        throw new InvalidArgumentException('Invalid content name');
    }
    return $name === 'global' ? CONTENT_DIR . '/global.json' : CONTENT_DIR . "/pages/$name.json";
}

function content_load(string $name): ?array
{
    static $cache = [];
    $file = content_file($name);
    if (!is_file($file)) {
        return null;
    }
    $mtime = filemtime($file);
    if (!isset($cache[$name]) || $cache[$name][0] !== $mtime) {
        $data = json_decode((string) file_get_contents($file), true);
        if (!is_array($data)) {
            throw new RuntimeException("Broken content file: $name");
        }
        $cache[$name] = [$mtime, $data];
    }
    return $cache[$name][1];
}

/** Save content; the previous version goes to content/backups/. */
function content_save(string $name, array $data): void
{
    $file = content_file($name);
    if (is_file($file)) {
        $dir = CONTENT_DIR . '/backups/' . $name;
        ensure_dir($dir);
        copy($file, $dir . '/' . date('Y-m-d_H-i-s') . '_' . bin2hex(random_bytes(2)) . '.json');
        $old = content_backups($name);
        foreach (array_slice($old, BACKUPS_KEEP) as $b) {
            @unlink($dir . '/' . $b['file']);
        }
    }
    write_file_atomic($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
    clearstatcache(true, $file);
}

/** Backups, newest first: [{file, time}] */
function content_backups(string $name): array
{
    content_file($name); // validates the name
    $dir = CONTENT_DIR . '/backups/' . $name;
    $list = [];
    foreach (is_dir($dir) ? scandir($dir) : [] as $f) {
        if (preg_match('/^(\d{4}-\d{2}-\d{2})_(\d{2})-(\d{2})-(\d{2})_[0-9a-f]+\.json$/', $f, $m)) {
            $list[] = ['file' => $f, 'time' => strtotime("$m[1] $m[2]:$m[3]:$m[4]")];
        }
    }
    usort($list, fn($a, $b) => strcmp($b['file'], $a['file']));
    return $list;
}

function content_restore(string $name, string $backupFile): void
{
    if (!preg_match('/^[\w-]+\.json$/', $backupFile)) {
        throw new InvalidArgumentException('Invalid backup');
    }
    $src = CONTENT_DIR . '/backups/' . $name . '/' . $backupFile;
    $data = is_file($src) ? json_decode((string) file_get_contents($src), true) : null;
    if (!is_array($data)) {
        throw new RuntimeException('Backup not found');
    }
    content_save($name, $data);
}

/** All pages: name => page data (sorted by path). Note: PHP turns the key "404" into an int – cast with (string). */
function content_pages(): array
{
    $pages = [];
    foreach (glob(CONTENT_DIR . '/pages/*.json') as $file) {
        $name = basename($file, '.json');
        $pages[$name] = content_load($name);
    }
    uasort($pages, fn($a, $b) => [$a['path'] !== '/', $a['path']] <=> [$b['path'] !== '/', $b['path']]);
    return $pages;
}

function page_by_path(string $path): ?string
{
    foreach (content_pages() as $name => $page) {
        if ($page['path'] === $path) {
            return (string) $name;
        }
    }
    return null;
}

/** Find a field by "section.key" in the page, then in global content. */
function content_field(string $ref): ?array
{
    [$section, $key] = array_pad(explode('.', $ref, 2), 2, '');
    foreach ([$GLOBALS['page'] ?? null, content_load('global')] as $doc) {
        foreach ($doc['sections'] ?? [] as $s) {
            if ($s['key'] !== $section) {
                continue;
            }
            foreach ($s['fields'] as $f) {
                if ($f['key'] === $key) {
                    return $f;
                }
            }
        }
    }
    return null;
}

/** Pages of one type (options.type: "article" | "reference"), sorted by options.date (newest first) or options.order. */
function pages_of_type(string $type): array
{
    $list = [];
    foreach (content_pages() as $name => $page) {
        if (($page['options']['type'] ?? '') === $type) {
            $list[(string) $name] = $page;
        }
    }
    uasort($list, function ($a, $b) use ($type) {
        $oa = $a['options'];
        $ob = $b['options'];
        if ($type === 'reference') {
            return ($oa['order'] ?? 99) <=> ($ob['order'] ?? 99);
        }
        return [(string) ($ob['date'] ?? ''), $oa['order'] ?? 0] <=> [(string) ($oa['date'] ?? ''), $ob['order'] ?? 0];
    });
    return $list;
}

/** First field of the given type in a page (e.g. the main image), or null. */
function page_field(array $page, string $section, string $key): ?array
{
    foreach ($page['sections'] as $s) {
        if ($s['key'] === $section) {
            foreach ($s['fields'] as $f) {
                if ($f['key'] === $key) {
                    return $f;
                }
            }
        }
    }
    return null;
}
