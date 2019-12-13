<?php
namespace Metro;
require "vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$main = new Main(getenv('JSON_END_POINT'), $argv);
$offers = $main->getFilteredOffers();

echo PHP_EOL;
if(!empty($offers)){
    $size = sizeof($offers);
    if($size > 1){
        echo "There are $size offers:" . PHP_EOL;
    }else{
        echo "There is 1 offer:" . PHP_EOL;
    }
    foreach($offers as $offer){
        $offer->display();
    }
}else{
    echo "No offers" . PHP_EOL;
}
echo PHP_EOL;
?>