
<h3>Training Sessions</h3>
<?php if (isset($trainingList) && sizeof($trainingList) > 0) : ?>
	<table>
		<thead>
			<tr>
				<td>Name</td>
				<td>Number</td>
				<td>Start Date</td>
				<td>End Date</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($trainingList as $currentTraining) : ?>
						<tr class='clickable-row' data-href='list.php?tid=<?= $currentTraining['ses_number'] ?>&tname=<?= $currentTraining['tra_name'] ?>'>
							<td><?= $currentTraining['tra_name'] ?></td>
							<td><?= $currentTraining['ses_number'] ?></td>
							<td><?= $currentTraining['ses_start_date'] ?></td>
							<td><?= $currentTraining['ses_end_date'] ?></td>
						</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else :?>
	No training
<?php endif; ?>

<?php if ($rowCount > 20) : ?>
	<?php if ($page > 1) : ?>
	<ul id="navButtons">
		<li><a name="buttonStart" class="navButton" id="buttonStart" href="?page=<?= 1 ?>">First page</a></li>
		<li><a name="buttonPrev" class="navButton" id="buttonPrev" href="?page=<?= $page -1 ?>">Previous page</a></li>
	<?php endif ?>
		<li><a name=="buttonNext" class="navButton" id="buttonNext" href="?page=<?= $page +1 ?>">Next page</a></li>
	</ul>
<?php endif ?>