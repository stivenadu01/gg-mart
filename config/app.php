<?php

date_default_timezone_set("Asia/Makassar"); // ubah sesuai zona waktu
define('APP_NAME', $_ENV['APP_NAME'] ?? 'My App');
define('BASE_URL', rtrim($_ENV['BASE_URL'] ?? '', '/'));
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/src/includes/');
