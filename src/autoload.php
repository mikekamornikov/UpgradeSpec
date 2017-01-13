<?php

// application or vendor context
$autoload = [
    __DIR__ . '/../vendor/autoload.php', // application bin or phar
    __DIR__ . '/../autoload.php',        // vendor bin
    __DIR__ . '/../../../autoload.php'   // vendor
];

foreach ($autoload as $file) {
    if (file_exists($file)) {
        require $file;
        break;
    }
}
