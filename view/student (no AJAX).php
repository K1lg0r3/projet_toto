<h3>Info étudiant</h3>
<?php if (isset($studentInfo) && sizeof($studentInfo) > 0) : ?>
	<?php if ((!empty($_POST)) && ($_POST['edit'])) :?>
		<form action="" method="post">
			<fieldset>
				<legend>Add a student</legend>
				<input type="text" name="studentName" value="<?= $lastname ?>" placeholder="Surname"><br />
				<input type="text" name="studentFirstname" value="<?= $firstname ?>" placeholder="Firstname"><br />
				<input type="email" name="studentEmail" value="<?= $email ?>" placeholder="E-mail"><br />
				<input type="date" name="studentBirhtdate" value="<?= $birthdate ?>" placeholder="Date of birth (yyyy-mm-dd)"><br />
				City:<br />
				<select name="cit_id">
					<option value="0">Please choose:</option>
					<?php foreach ($citiesList as $key=>$value) :?>
					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>
				</select><br />
				Nationality:<br />
				<select name="cou_id">
					<option value="0">Please choose:</option>
					<?php foreach ($countriesList as $key=>$value) :?>
					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>
				</select><br />
				Friendliness:<br />
				<select name="stu_friendliness">
					<option value="">Please choose:</option>
					<?php foreach ($friendlinessList as $key=>$value) :?>
					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>
				</select><br />
				<input class="button" id="validate" name="validate" type="submit" value="Validate"><br />
			</fieldset>
		</form>
	<?php elseif ((!empty($_GET)) && ($_GET['id'])) :?>
		<ul id="studentInfo">
		<?php foreach ($studentInfo as $currentStuInfo) : ?>
			<li>SURNAME: <?= $currentStuInfo['stu_lname'] ?></li>
			<li>FIRSTNAME: <?= $currentStuInfo['stu_fname'] ?></li>
			<li>EMAIL: <?= $currentStuInfo['stu_email'] ?></li>
			<li>CITY: <?= $currentStuInfo['cit_name'] ?></li>
			<li>COUNTRY: <?= $currentStuInfo['cou_name'] ?></li>
			<li>FRIENDLINESS: <?= $currentStuInfo['stu_friendliness'] ?></li>
			<li>DATE OF BIRTH: <?= $currentStuInfo['birthdate'] ?></li>
		<?php endforeach; ?>
		</ul>
		<form action="" method="post"><input id="edit" name="edit" type="submit" value="Edit"></form>
	<?php else :?>
		Error!
	<?php endif; ?>
<?php endif; ?>
