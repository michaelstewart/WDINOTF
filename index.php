<?php
    include 'stdlib.php';
    include 'pages.php';

    $site = new csite();
    initialise_site($site);
    

    if (isset($_GET['page'])) {
    	$p = $_GET['page'];
    } else {
    	$p = 'index';
    }
    
	$page = load_page($p);	

    $site->setPage($page);

    $site->render();
?>
