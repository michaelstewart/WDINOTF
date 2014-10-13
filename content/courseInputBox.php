<div id="main-box">
    <div id="quote">
	    <form method="get">
	    What do I need on my <input type="text" id="course_input" name="course" value="<?php if (isset($_GET['course'])) { echo $_GET['course']; } else { echo 'ECON1010'; } ?>" onClick="clearInputBox(this);"> Final?
	    <input type="hidden" name="page" value="search">
	    </form>
    </div>
</div>