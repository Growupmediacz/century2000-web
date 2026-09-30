<?php
/*
 * Set the admin login. Creates config.php (from config.example.php) when missing.
 *
 *   php tools/set-password.php [username]
 */
declare(strict_types=1);

$root = dirname(__DIR__);
$config = "$root/config.php";
if (!is_file($config)) {
    copy("$root/config.example.php", $config);
    echo "Vytvořen config.php\n";
}

$user = $argv[1] ?? 'admin';
echo "Uživatelské jméno: $user\n";
echo 'Nové heslo (min. 10 znaků): ';
system('stty -echo');
$password = trim((string) fgets(STDIN));
system('stty echo');
echo "\nZnovu heslo: ";
system('stty -echo');
$again = trim((string) fgets(STDIN));
system('stty echo');
echo "\n";
if (mb_strlen($password) < 10 || $password !== $again) {
    fwrite(STDERR, "Hesla se neshodují nebo jsou kratší než 10 znaků.\n");
    exit(1);
}

$text = (string) file_get_contents($config);
$set = fn(string $key, string $value, string $text) => preg_replace_callback(
    "/('$key'\s*=>\s*)'[^']*'/", fn($m) => $m[1] . var_export($value, true), $text, 1);
$text = $set('user', $user, $text);
$text = $set('password_hash', password_hash($password, PASSWORD_DEFAULT), $text);
if (preg_match("/'secret'\s*=>\s*''/", $text)) {
    $text = $set('secret', bin2hex(random_bytes(32)), $text);
}
file_put_contents($config, $text);
echo "Heslo uloženo do config.php.\n";
