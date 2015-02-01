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
			$db->query('UPDATE items SET meli_status="'.$item->status.'", meli_id="'.$item->id.'", finish_date="'.$item->stop_time.'", title="'.$item->title.'", created="'.$item->start_time.'", seller_id="'.$item->seller_id.'", price="'.$item->price.'", currency="'.$item->currency_id.'", buying_mode="'.$item->buying_mode.'", category_id="'.$item->category_id.'", last_updated="'.$item->last_updated.'", sold='.$item->sold_quantity.', available_quantity='.$item->available_quantity.', publication_type="'.$item->listing_type_id.'", last_cron_run="'.date('Y-m-d H:i:s').'" WHERE id = '.$item_result['id']);
		} else {
			$db->query('INSERT INTO items (analysis_id, source_id, meli_status, meli_id, finish_date, title, created, seller_id, price, currency, buying_mode, category_id, last_updated, sold, available_quantity, publication_type, last_cron_run) VALUES ('.$source['analysis'].', '.$source['id'].', "'.$item->status.'", "'.$item->id.'", "'.$item->stop_time.'", "'.$item->title.'", "'.$item->start_time.'", "'.$item->seller->id.'", "'.$item->price.'", "'.$item->currency_id.'", "'.$item->buying_mode.'", "'.$item->category_id.'", "'.$item->last_updated.'", '.$item->sold_quantity.', '.$item->available_quantity.', "'.$item->listing_type_id.'", "'.date('Y-m-d H:i:s').'")');
		}
		
	}
	
}