<?php
session_start();
use src\App;

require_once realpath("vendor/autoload.php");

$basePath = __DIR__;

$app = new App($basePath);
$app->init();



