<?php

class indexPage extends cpage {

	function __construct() {
		parent::__construct('What Do I Need on the Final?');
	}
	
	function loadPage() {
		ob_start(); // Start output buffering.
		include('content/index.php');
		$content = ob_get_clean();
		
		$this->setContent($content);
	
	}


}
?>