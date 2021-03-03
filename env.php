<?php
require_once realpath(__DIR__."/vendor/autoload.php");

use Dotenv\Dotenv;
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::create(__DIR__);
    $dotenv->load();
}
?>