<?php

class searchPage extends cpage {
	
	function __construct() {
		parent::__construct('What Do I Need on the Final?');
	}
	
	function loadPage() {
		ob_start(); // Start output buffering.
		if (isset($_GET['course'])) {
			$results = false;
			$courseCode = $_GET['course'];
			$course = new Course($courseCode);
			$assessmentItems = $course->fetchAssessment();
			if ($assessmentItems) {
				$total = $course->total();
				if (isset($_POST['submit'])) {
					$results = $course->calculateResults($_POST);				
				} else {
					$course->addSearch();
				}
				include('content/search.php');
			} else {
				include('content/notFound.php');
			}
		} else {
			include('content/404.php');
		}
		
		
		$content = ob_get_clean();
		
		$this->setContent($content);	
	}
	
	function assessmentTable($assessmentItems) {

		foreach($assessmentItems as $item) {
			include('content/assessmentTable.php');
		
		}		
		
	}
	
	function resultsTable($results) {
		foreach($results as $grade => $result) {
			include('content/resultsTable.php');		
		}
	
	}
	
	function totalClass($total) {
		if ($total != 100) {
			return 'wrongtotal';
		} else {
			return '';
		}
	
	}
	

}
?>