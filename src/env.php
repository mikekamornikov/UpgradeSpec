<?php

use Symfony\Component\Dotenv\Dotenv;

const APPLICATION_ROOT = __DIR__ . '/../';
const DS = DIRECTORY_SEPARATOR;

/**
 * Sets env variable.
 *
 * @param $name
 * @param $value
 */
function setenv($name, $value)
{
    putenv($name); // unset variable
    putenv("$name=$value");
    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
}

$env = new Dotenv();

$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $env->populate($env->parse(file_get_contents($envPath), $envPath));
}

$envPath = __DIR__ . '/../.env.dist';
$env->populate($env->parse(file_get_contents($envPath), $envPath));

putenv(sprintf('APPLICATION_VERSION=%s', '@package_version@'));

$basename = basename(getenv('PHAR_NAME'), '.phar');
$defaultPath = sys_get_temp_dir() . '/.' . $basename;
if (!getenv('BACKUP_PATH')) {
    setenv('BACKUP_PATH', $defaultPath . '/' . $basename . '-old.phar');
}

if (!getenv('CACHE_PATH')) {
    setenv('CACHE_PATH', $defaultPath . '/cache');
}

if (!getenv('TEMPLATE_PATH')) {
    setenv('TEMPLATE_PATH', __DIR__ . '/../resources/templates');
}

// using "markdown" as default format
setenv('TEMPLATE_PATH', getenv('TEMPLATE_PATH') . '/markdown');
