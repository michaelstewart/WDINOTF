<?php include('courseInputBox.php'); ?>


<div id="content">

	<form method=post>
        <table>
          <tr class="table-top">
            <td>Assessment Item</td>
            <td>Weight</td>
            <td>Your Score</td>
          </tr>
          <?php $this->assessmentTable($assessmentItems); ?>
          <tr class="table-bottom">
          	<td>Total</td>
            <td class="<?php echo $this->totalClass($total); ?>"><?php echo $total; ?>%</td>
            <td></td>
          </tr>
          </table>
     <input type="submit" name="submit" value="Calculate!" id="submit">
     </form>
     
<?php if ($total != 100) {
	echo '<br>';
	include('profileIssue.php');
} ?>

<?php if (is_array($results)) {?>
	<table>
		<tr class="table-top">
			<td>For a </td>
			<td>You need</td>
		</tr>
		<?php $this->resultsTable($results); ?>
	</table>
<?php } else 
	if (is_numeric($results)) { ?>
	<h2>You should get a <?php if ($results) { echo $results; } else { echo 'Fail'; } ?></h2>
<?php } ?>

<p><br>Update: Typing a fraction for the score eg. 18/25 also works.</p>


</div>