<?php
class Scraper {

	var $courseName;
	var $assessmentItems;
	

	function __construct($courseName){
		$this->courseName = $courseName;
		
		include_once('includes/simple_html_dom.php');
		
		$link = $this->searchCourse($courseName);
		if ($link) {
			$profileLink = $this->getProfileLink($link);
			if ($profileLink) {
				$this->assessmentItems = $this->getProfile($profileLink);
				return;
			}
		}
		$this->assessmentItems = false;
	}
	
	function searchCourse($courseName) {
		$url = "http://www.uq.edu.au/study/search.html?keywords=" . $courseName . "&searchType=all&archived=false&CourseParameters%5Bsemester%5D=2012:2";

		// get DOM from URL or file
		$html = file_get_html($url);		
		
		// find all div tags
		if (!($html)) return false;
		
		$html = $html->find('div#courses-container', 0);
		
		if (!($html)) return false;
		
		$links = $html->find('a');
		
		$html->clear(); 
		unset($html);
		
		foreach($links as $e)  {
			
			$link = $e->href;
			
			if (strstr($link,'offer')) {
				return 'http://www.uq.edu.au' . $link;
			}
		}
		
		return false;
	}
	
	function getProfileLink($link) {
		$html = file_get_html($link);
		
		if (!($html)) return false;
		
		$profileLink = $html->find('div#description', 0)->find('table.offerings', 0)->find('td', 7)->find('a.profile-available', 0)->href;
		
		$html->clear(); 
		unset($html);
		return $profileLink;
	
	}
	
	function changeLinkSection($link) {
		$link = str_replace("section=1", "section=5", $link);
		$link = str_replace("&amp;", "&", $link);
		return $link;
	}
	
	function getProfile($link) {
		$link = $this->changeLinkSection($link);

		// Get the File
		$html = file_get_html($link);
		
		// Find the content container
		if (!($html)) return false;
		
		$html = $html->find('div#content', 0);
		
		// Split on the assessment Detail section
		$html = split('<a name="assessmentDetail"></a>', $html);
		
		// Convert to DOM again

		$html = str_get_html($html[1]);	
		
		if (!($html)) return false;
		
		$html = $html->find('div.infoIndent', 0);
		
		$headings = array();
		$weights = array();
		
		if (!($html)) return false;
		
		// Get the headings
		foreach($html->find('div.assessmentheading') as $e) {
			$headings[] = $e->innertext;
		}
		
		// Get the weights
		foreach($html->find('div.assessDetail') as $e) {
			$inner = $e->innertext;
			$sections = split("<strong>", $inner);
			foreach($sections as $i) {
				if (stripos($i, "Weight:") === 0) {
					$i = split("<br />  ", $i);
					$i = split("</strong>", $i[0]);
					$percent = $i[1];
					$weights[] = floatval($percent);
				}
			}
		}
		
		$array = array();
		$i = 0;
		foreach($headings as $e) {
			$array[] = array($e, $weights[$i]);
			$i++;
		}
		
		return $array;
		
	}
	
	function getAssessment() {
		return $this->assessmentItems;
	}


}


?>