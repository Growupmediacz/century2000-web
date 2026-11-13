<?php
/* Old URL → new URL (see app/redirects.php). Returns the target for a request path, or null. */
declare(strict_types=1);

function redirect_map(): array
{
    static $map = null;
    return $map ??= require APP_DIR . '/redirects.php';
}

function redirect_target(string $path): ?string
{
    $key = rtrim($path, '/') ?: '/';
    return redirect_map()[$key] ?? null;
}
