<?php

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/../lib/meli.php');

$meli = new Meli(MELI_APP_ID, MELI_SECRET);

$params = array();
$result = $meli->get('/items?ids=MLA543411440,MLA543251257,MLA542374771', $params);

echo '<pre>';
var_dump($result);