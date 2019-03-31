<?php 

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/vendor/simple_html_dom.php";

$client = new MongoDB\Client(
    'mongodb+srv://admin:elibrary1234@cluster0-sndra.mongodb.net/test?retryWrites=true');
  
$db = $client->Elibrary;
$col = $db->Texts;

$res = $col->findOne();

echo "<div>" . $res["text"] . "</div>";

