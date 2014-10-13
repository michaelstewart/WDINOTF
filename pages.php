<?php

function load_page($p) {
	
	switch($p) {
		case 'search':
			$page = new searchPage();
			$page->loadPage();
			return $page;
			break;	
				
		default:
			$page = new indexPage();
			$page->loadPage();
			return $page;
	
	}

}


?>