<?php

date_default_timezone_set("Asia/Makassar");
define('APP_NAME', $_ENV['APP_NAME'] ?? 'My App');
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/src/includes/');
define('UPLOADS_PATH', ROOT_PATH . '/public/uploads/');

define('BASE_URL', rtrim($_ENV['BASE_URL'] ?? '', '/'));
define('ASSETS_URL', BASE_URL . '/assets/');
define('UPLOADS_URL', BASE_URL . '/uploads/');
