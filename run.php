<?php
namespace Metro;
require "vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$main = new Main(getenv('JSON_END_POINT'), $argv);
$offers = $main->getFilteredOffers();
print_r($offers);
?>