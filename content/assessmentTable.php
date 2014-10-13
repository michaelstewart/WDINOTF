<tr>
	<td><?php echo $item['assessmentName'] ?></td>
	<td><?php echo $item['weight'] ?>%</td>
	<td><input type="text" class="scoreBox" name="<?php echo $item['indx'] ?>" value="<?php if (isset($_POST[$item['indx']])) echo $_POST[$item['indx']]; ?>">% out of 100%</td>
</tr>