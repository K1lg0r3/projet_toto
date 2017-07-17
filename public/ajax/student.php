<?php

require dirname(dirname(dirname(__FILE__)))."/inc/config.php";

// Get the student list and populate the array
$query = 'SELECT stu_id, stu_lastname AS stu_lname, stu_firstname AS stu_fname,
				 stu_email, cou_name, cit_name,
				 fri_name AS stu_friendliness, stu_birthdate AS birthdate,
				 ses_number, tra_name
		  FROM student
		  LEFT OUTER JOIN city ON city.cit_id = student.city_cit_id
		  LEFT OUTER JOIN country ON country.cou_id = city.country_cou_id
		  LEFT OUTER JOIN friendliness ON friendliness.fri_id = student.friendliness_fri_id
		  LEFT OUTER JOIN session ON session.ses_id = student.session_ses_id
		  LEFT OUTER JOIN training ON training.tra_id = session.training_tra_id
		  WHERE stu_id = :st_id
		  LIMIT 1
		';

// id must be int
$_POST['id'] = (int) $_POST['id'];

$pdoStatement = $pdo->prepare($query);
$pdoStatement->bindValue(':st_id', $_POST['id']);


if ($pdoStatement->execute() == false) {
	print_r($pdoStatement->errorInfo());
}
else {
	$studentInfo = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
}
// Get data
$studentId = $studentInfo[0]['stu_id'];
$lastname = $studentInfo[0]['stu_lname'];
$firstname = $studentInfo[0]['stu_fname'];
$email = $studentInfo[0]['stu_email'];
$birthdate = $studentInfo[0]['birthdate'];
$city = isset($_POST['cit_id']) ? strip_tags(trim($_POST['cit_id'])) : '';
$country = isset($_POST['cou_id']) ? strip_tags(trim($_POST['cou_id'])) : '';
$friendliness = isset($_POST['stu_friendliness']) ? strip_tags(trim($_POST['stu_friendliness'])) : '';

?>

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
