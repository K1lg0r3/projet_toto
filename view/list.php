
<?php if ($search) : ?>
	<h3>Search Result</h3>
<?php elseif ($sessionId) : ?>
	<h3>Students List For Session Number <?= $sessionId ?> In <?= $sessionName ?></h3>
<?php else : ?>
	<h3>Students List</h3>
<?php endif ?>

<?php if (isset($studentList) && sizeof($studentList) > 0) : ?>
	<table>
		<thead>
			<tr>
				<td>Surname</td>
				<td>Firstname</td>
				<td>E-mail</td>
				<td>City</td>
				<td>Nationality</td>
				<td>Friendliness</td>
				<td>Date Of Birth</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($studentList as $currentEtudiant) : ?>
						<tr class='clickable-row' data-href='student.php?id=<?= $currentEtudiant['stu_id'] ?>'>
							<td><?= $currentEtudiant['stu_lname'] ?></td>
							<td><?= $currentEtudiant['stu_fname'] ?></td>
							<td><?= $currentEtudiant['stu_email'] ?></td>
							<td><?= $currentEtudiant['cit_name'] ?></td>
							<td><?= $currentEtudiant['cou_name'] ?></td>
							<td><?= $currentEtudiant['stu_friendliness'] ?></td>
							<td><?= $currentEtudiant['birthdate'] ?></td>
						</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else :?>
	No student
<?php endif; ?>

<?php if (!$search) : ?>
	<ul id="navButtons">
	<?php if ($page > 1) : ?>
		<li><a name="buttonStart" class="navButton" id="buttonStart" href="?page=<?= 1 ?>">First page</a></li>
		<li><a name="buttonPrev" class="navButton" id="buttonPrev" href="?page=<?= $page -1 ?>">Previous page</a></li>
	<?php endif ?>
		<li><a name=="buttonNext" class="navButton" id="buttonNext" href="?page=<?= $page +1 ?>">Next page</a></li>
	</ul>
<?php endif ?>