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
	
	// Connect to DB and run scraps for all sources that are dated more than 1 hour
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	$sources = $db->query('SELECT sources.id, sources.type, sources.body FROM sources, analysis WHERE analysis.status = "active" AND sources.last_cron_run < DATE_SUB(NOW(), INTERVAL 1 HOUR)');
	while ($source = $sources->fetch_array(MYSQLI_ASSOC)) {
		
		switch ($source['type']) {
			
			case 'meli_search':
				persistItems(scrapItemsBySearch($source['body']));
			break;
			
			case 'meli_category':
				persistItems(scrapItemsByCategory($source['body']));
			break;
			
			case 'meli_csv':
				persistItems(scrapItemsById($source['body']));
			break;
			
		}
		
		$db->query('UPDATE sources SET last_cron_run = "'.date('Y-m-d H:i:s').'" WHERE id = '.$source['id']);
		
	}
	
}

function persistItems($items=array()) {
	
	
	
}