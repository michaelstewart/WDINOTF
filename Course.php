<?php

class Course {

	var $courseCode;
	var $year = 2012;
	var $semester = 2;
	var $db;
	var $assessment;
	
	function __construct($course) {
		$this->courseCode = $course;
		$this->db = new Database();
		$this->db->connect();
	}
	
	function fetchAssessment() {
		// Check course is in DB
		$where = "year = " . $this->year . " AND semester = " . $this->semester . " AND courseCode =  '" . $this->courseCode . "'";
		if ($this->db->select('courseOfferings', '*', $where)) {
			$result = $this->db->getResult();
			if (count($result) == 0) {
				$added = $this->addAssessment();	// Add assessment to DB
			} else {
				$added = true;
			}
		}
		
		if ($added) {
			// Get Assessment from DB
			$where = "offeredYear = " . $this->year . " AND offeredSemester = " . $this->semester . " AND courseCode =  '" . $this->courseCode . "'";
			$order = 'indx ASC';
			if ($this->db->select('assessmentItems', '*', $where, $order)) {
				$result = $this->db->getResult();
				$this->assessment = $result;
				return $this->assessment;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}
	
	
	function addAssessment() {
		$assessment = $this->scrapeAssessment();
		if ($assessment  AND count($assessment) != 0) {
			if($this->insertOffering()) {
				$this->insertAssessment($assessment);
				return true;
			}
		} else {
			return false;
		}
	
	}
	
	function scrapeAssessment() {
		$scraper = new Scraper($this->courseCode);
		return $scraper->getAssessment();		
	}
	
	function insertOffering() {
		$courseArray = array($this->courseCode, $this->year, $this->semester);
		return $this->db->insert('courseOfferings', $courseArray);
	}
	
	function insertAssessment($assessment) {
		$courseArray = array($this->courseCode, $this->year, $this->semester);
		$i = 0;
		foreach($assessment as $e) {
			$this->db->insert('assessmentItems', array_merge($courseArray, $e, array($i)));
			$i++;
		}	
	}
	
	function calculateResults($form) {
		$results = results_array();		// The required total, will be replace with the required final Exam result.
		if ($this->assessment) {
			$completed = 0.0;
			$remaining = 0.0;
			foreach($this->assessment as $e) {				
				$index = $e['indx'];
				if (isset($form[$index]) AND $form[$index] != '') {
					if (strpos($form[$index], '/')) {
						$temp = split('/', $form[$index]);
						$value = floatval($temp[0])/floatval($temp[1]);
					} else {
						$value = floatval($form[$index])/100;
					}
					
					$completed += $e['weight']/100*$value;
				} else {
					$remaining += $e['weight']/100.0;
				}
			}
			if ($remaining == 0) return $this->gradeFrom($completed);
			foreach($results as $grade => $required) {				
				$result = ($required - $completed)/$remaining;
				$results[$grade] = $result;
			}
		} else {
			return false;
		}
		return $results;
	}
	
	
	function gradeFrom($score) {
		$results = results_array();
		foreach($results as $grade => $results) {
			if ($score > $results) {
				return $grade;
			}
		}
		return 0;
	}
	
	function total() {
		if ($this->assessment) {
			$total = 0.0;
			foreach($this->assessment as $e) {				
				$total += $e['weight'];				
			}
			return $total;
		} else {
			return false;
		}
	}
	
	function addSearch() {
		$array = array($this->courseCode);
		return $this->db->insert('searches', $array, 'courseCode');
	}
	
}



?>