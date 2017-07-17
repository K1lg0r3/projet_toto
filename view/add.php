	<form action="" method="post">
		<fieldset>
			<legend>Add a student</legend>
			<input type="text" name="studentName" value="" placeholder="Surname"><br />
			<input type="text" name="studentFirstname" value="" placeholder="Firstname"><br />
			<input type="email" name="studentEmail" value="" placeholder="E-mail"><br />
			<input type="date" name="studentBirhtdate" value="" placeholder="Date of birth (yyyy-mm-dd)"><br />
			<div id="upload">
				<input type="hidden" name="submitFile" value="1" /><br />
				<label for="fileForm">Upload picture</label>
				<input type="file" name="fileForm" id="fileForm" /><br />
			</div>
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
			<input type="submit" value="Valider"><br />
		</fieldset>
	</form>