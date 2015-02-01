<?php

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/../lib/meli.php');

function scrapItems($items=array()) {
	
	$meli = new Meli(MELI_APP_ID, MELI_SECRET);

	$params = array();
	$params['ids'] = implode($items, ',');
	$result = $meli->get('/items', $params);

	// echo '<pre>';
	// var_dump($result['body']);
	return $result['body'];
	
}

// Testing
$items = array('MLA543411440','MLA543251257','MLA542374771');
scrapItems($items);