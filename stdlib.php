<?php
    function __autoload($class) {
        include "$class.php";
    }

    function initialise_site(csite $site) {
    	error_reporting(0);
        $site->addHeader("header.php");
        $site->addFooter("footer.php");
    }
    
    function results_array() {
    	$results = array();
    	$results[7] = 0.85;
    	$results[6] = 0.75;
    	$results[5] = 0.65;
    	$results[4] = 0.50;
    	
    	return $results;
    }
?>