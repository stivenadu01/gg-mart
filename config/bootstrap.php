<?php
// 1. Load Composer Autoload

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// 2. Load .env
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// 3. session
require_once __DIR__ . '/session.php';

// 4. Database Connection
require_once __DIR__ . '/koneksi.php';


// 5. General Settings
date_default_timezone_set("Asia/Makassar"); // ubah sesuai zona waktu
define('APP_NAME', $_ENV['APP_NAME'] ?? 'My App');
define('BASE_URL', rtrim($_ENV['BASE_URL'] ?? '', '/'));
define('ROOT_PATH', __DIR__ . "/../");
define('ASSETS_PATH', BASE_URL . '/assets/');
define('IMG_PATH', BASE_URL . '/assets/img/');
define('UPLOADS_PATH',  BASE_URL . '/uploads/');
define("COMPONENTS_PATH", ROOT_PATH . '/src/components/');

// 6.functions
require_once ROOT_PATH . '/helpers/functions.php';
