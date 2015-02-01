<?php

// This file will have 3 triggers by GET['run']:
// run=hourly / run=daily / run=now
// They will trigger a different function each.

require_once(__DIR__.'/config.php');

switch ($_GET['run']) {
	case 'hourly':
		hourly();
	break;
	
	case 'daily':
		daily();
	break;
	
	case 'now':
		now();
	break;
	
	default:
	echo '<p>You are doing it wrong.</p>';
	break;
}

function hourly() {
	
	require_once(__DIR__.'/scrap-items.php');
	require(__DIR__.'/database.php');
	
	// Connect to DB and run scraps for all sources that are dated more than 1 hour
	$sources = $db->query('SELECT analysis.id as analysis, sources.id, sources.type, sources.body FROM sources, analysis WHERE analysis.status = "active" AND sources.last_cron_run < DATE_SUB(NOW(), INTERVAL 1 HOUR)');
	while ($source = $sources->fetch_array(MYSQLI_ASSOC)) {
		
		switch ($source['type']) {
			
			case 'meli_search':
				persistItems($source, scrapItemsBySearch($source['body']));
			break;
			
			case 'meli_category':
				persistItems($source, scrapItemsByCategory($source['body']));
			break;
			
			case 'meli_csv':
				persistItems($source, scrapItemsById($source['body']));
			break;
			
		}
		
		$db->query('UPDATE sources SET last_cron_run = "'.date('Y-m-d H:i:s').'" WHERE id = '.$source['id']);
		
	}
	
	fixer(); // Run fixer to collect data that didn't come in the API request.
	
}

function fixer() {
	
	// Fix missing data that doesn't come in every MELI API call
	require_once(__DIR__.'/scrap-items.php');
	require(__DIR__.'/database.php');
	
	// Connect to DB and collect visits for all items
	$items = $db->query('SELECT id, meli_id FROM items WHERE created IS NULL OR seller_id IS NULL LIMIT 50');
	$item_collector = array();
	
	while ($item = $items->fetch_array(MYSQL_ASSOC)) {
		$item_collector[] = $item['meli_id'];
	}

	if (count($item_collector)==0) {
		return FALSE;
	}
	
	$items = scrapItemsById(implode($item_collector, ','));
	
	foreach($items as $item) {
		$db->query('UPDATE items SET created = "'.$item->start_time.'", seller_id = '.$item->seller_id.' WHERE meli_id = "'.$item->id.'"');
	}
	
}

function daily() {
	
	require_once(__DIR__.'/scrap-items.php');
	require(__DIR__.'/database.php');
	
	// Connect to DB and collect visits for all items
	$items = $db->query('SELECT id, meli_id FROM items WHERE following = "yes"');
	$item_collector = array();
	
	while ($item = $items->fetch_array(MYSQL_ASSOC)) {
		$item_collector[] = $item['meli_id'];
	}

	if (count($item_collector)==0) {
		return FALSE;
	}
	
	$visits = scrapVisits(implode($item_collector, ','));
	
	foreach($visits as $meli_id=>$visit) {
		$db->query('UPDATE items SET visits = '.$visit.' WHERE meli_id = "'.$meli_id.'"');
	}
	
}

function persistItems($source, $items) {

	require(__DIR__.'/database.php');

	foreach ($items as $item) {
		// die('SELECT id FROM items WHERE meli_id = "'.$item->id.'" AND source_id = '.$source['id'].' LIMIT 1');
		$result = $db->query('SELECT id FROM items WHERE meli_id = "'.$item->id.'" AND analysis_id = '.$source['analysis'].' LIMIT 1');

		if ($result->num_rows > 0) {
			$item_result = $result->fetch_array(MYSQLI_ASSOC);
			$db->query('UPDATE items SET meli_id="'.$item->id.'", finish_date="'.$item->stop_time.'", title="'.$item->title.'", price="'.$item->price.'", currency="'.$item->currency_id.'", buying_mode="'.$item->buying_mode.'", category_id="'.$item->category_id.'", sold='.$item->sold_quantity.', available_quantity='.$item->available_quantity.', publication_type="'.$item->listing_type_id.'", last_cron_run="'.date('Y-m-d H:i:s').'", url="'.$item->permalink.'" WHERE id = '.$item_result['id']);
		} else {
			$db->query('INSERT INTO items (analysis_id, source_id, meli_id, finish_date, title, price, currency, buying_mode, category_id, sold, available_quantity, publication_type, last_cron_run, url) VALUES ('.$source['analysis'].', '.$source['id'].', "'.$item->id.'", "'.$item->stop_time.'", "'.$item->title.'", "'.$item->price.'", "'.$item->currency_id.'", "'.$item->buying_mode.'", "'.$item->category_id.'", '.$item->sold_quantity.', '.$item->available_quantity.', "'.$item->listing_type_id.'", "'.date('Y-m-d H:i:s').'", "'.$item->permalink.'")');
		}
		
	}
	
}