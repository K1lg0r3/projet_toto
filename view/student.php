<h3>Info étudiant</h3>
<?php //if (isset($studentInfo) && sizeof($studentInfo) > 0) : ?>
	<?php if (!empty($_POST) && !empty($_POST['edit'])) :?>
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
	<?php elseif (!empty($_GET) && !empty($_GET["id"])) :?>
		<div id="studentContent"></div>
		<script type="text/javascript">
			$(document).ready(function() {
				$.ajax({
					url : 'ajax/student.php',
					method : 'POST',
					dataType : 'html',
					data : {
						id : <?= $_GET["id"] ?>
					},
					success : function(response) {
						$('#studentContent').html(response);
						var stateObj = { student: "detail" };
						<?php require dirname(dirname(__FILE__))."/inc/config.php"; ?>
						history.replaceState(stateObj, "", <?= $config["site_url"]."/".__FILE__; ?>);
						location.hash = 'student' + <?= $_GET["id"] ?>;
					}
				});
			});
		</script>
	<?php else :?>
		Error!
	<?php endif; ?>
<?php //endif; ?>
