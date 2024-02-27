<?php

namespace App\config;

use Dotenv\Dotenv;

$rootDir = dirname(dirname(__DIR__));
$dotenv = Dotenv::createImmutable($rootDir);
$dotenv->load();
