<?php

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/../lib/meli.php');

function scrapVisits($items='') {
	
	$meli = new Meli(MELI_APP_ID, MELI_SECRET);

	$params = array();
	$params['ids'] = urlencode(trim($items));
	$result = $meli->get('/visits/items', $params);

	return (array) $result['body'];

}

function scrapItemsById($items='') {
	
	$meli = new Meli(MELI_APP_ID, MELI_SECRET);

	$params = array();
	$params['ids'] = urlencode(trim($items));
	$result = $meli->get('/items', $params);

	return $result['body'];
	
}

function scrapItemsBySearch($query='', $offset=0) {
	
	$meli = new Meli(MELI_APP_ID, MELI_SECRET);

	$params = array();
	$params['q'] = urlencode(trim($query));
	$params['offset'] = $offset;
	$result = $meli->get('/sites/'.MELI_SITE.'/search', $params);
	
	$return = $result['body'];

	if ($result['body']->paging->total > ($offset+50)) {
		
		$add = scrapItemsBySearch($query, ($offset+50));
		$return->results = array_merge($return->results, $add->results);

	}
	
	return $return->results;
	
}

function scrapItemsByCategory($category='', $offset=0) {
	
	$meli = new Meli(MELI_APP_ID, MELI_SECRET);

	$params = array();
	$params['category'] = urlencode(trim($category));
	$params['offset'] = $offset;
	$result = $meli->get('/sites/'.MELI_SITE.'/search', $params);
	
	$return = $result['body'];

	if ($result['body']->paging->total > ($offset+50)) {
		
		$add = scrapItemsByCategory($category, ($offset+50));
		$return->results = array_merge($return->results, $add->results);

	}
	
	return $return->results;
	
}

// Testing
// var_dump(scrapItemsById('MLA543411440,MLA543251257,MLA542374771'));
// var_dump(scrapItemsBySearch('ipod touch'));
// var_dump(scrapItemsByCategory('MLA1117'));
// var_dump(scrapVisits('MLA543411440,MLA543251257,MLA542374771'));
