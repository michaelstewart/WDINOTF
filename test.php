<?php
include('Database.php');
include('Course.php');
include('Scraper.php');
include('includes/simple_html_dom.php');

$course = new Course('ECON1020');
$course->fetchAssessment();



?>