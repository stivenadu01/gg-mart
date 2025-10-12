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
require_once __DIR__ . '/app.php';


// 6.functions
require_once ROOT_PATH . '/helpers/functions.php';
