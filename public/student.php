<?php

require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/view/header.php";
// require dirname(dirname(__FILE__))."/public/ajax/student.php";

// // Get the student list and populate the array
// $query = 'SELECT stu_id, stu_lastname AS stu_lname, stu_firstname AS stu_fname,
// 				 stu_email, cou_name, cit_name,
// 				 fri_name AS stu_friendliness, stu_birthdate AS birthdate,
// 				 ses_number, tra_name
// 		  FROM student
// 		  LEFT OUTER JOIN city ON city.cit_id = student.city_cit_id
// 		  LEFT OUTER JOIN country ON country.cou_id = city.country_cou_id
// 		  LEFT OUTER JOIN friendliness ON friendliness.fri_id = student.friendliness_fri_id
// 		  LEFT OUTER JOIN session ON session.ses_id = student.session_ses_id
// 		  LEFT OUTER JOIN training ON training.tra_id = session.training_tra_id
// 		  WHERE stu_id = :st_id
// 		  LIMIT 1
// 		';
//
// // id must be int
// $_GET['id'] = (int) $_GET['id'];
//
// $pdoStatement = $pdo->prepare($query);
// $pdoStatement->bindValue(':st_id', $_GET['id']);
//
//
// if ($pdoStatement->execute() == false) {
// 	print_r($pdoStatement->errorInfo());
// }
// else {
// 	$studentInfo = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
// }
// // Get data
// $studentId = $studentInfo[0]['stu_id'];
// $lastname = $studentInfo[0]['stu_lname'];
// $firstname = $studentInfo[0]['stu_fname'];
// $email = $studentInfo[0]['stu_email'];
// $birthdate = $studentInfo[0]['birthdate'];
// $city = isset($_POST['cit_id']) ? strip_tags(trim($_POST['cit_id'])) : '';
// $country = isset($_POST['cou_id']) ? strip_tags(trim($_POST['cou_id'])) : '';
// $friendliness = isset($_POST['stu_friendliness']) ? strip_tags(trim($_POST['stu_friendliness'])) : '';

// UPDATE
if ((!empty($_POST)) && ($_POST['edit']) == "Validate") {
	// Je considère les données valides avant de les valider
	$formValid = true;

	// 2 - Validation des données
	if (empty($lastname)) {
		$formValid = false;
		echo 'Please fill the lastname field<br>';
	}
	else if (strlen($lastname) < 2) {
		$formValid = false;
		echo 'The surname must be at least two characters long<br>';
	}
	if (empty($firstname)) {
		$formValid = false;
		echo 'Please fill the firstname field<br>';
	}
	else if (strlen($firstname) < 2) {
		$formValid = false;
		echo 'The firstname must be at least two characters long<br>';
	}
	if (!$email) {
		$formValid = false;
		echo 'Please enter a valid e-mail<br>';
	}
	if (empty($birthdate)) {
		$formValid = false;
		echo 'Please fill the date of birth field<br>';
	}
	else if (!(validateDate($birthdate, 'Y-m-d'))) {
		$formValid = false;
		echo 'Please enter a valid date<br>';
	}
	if (empty($city)) {
		$formValid = false;
		echo 'Please select a city<br>';
	}
	if (empty($country)) {
		$formValid = false;
		echo 'Please select a country<br>';
	}
	if (empty($friendliness)) {
		$formValid = false;
		echo 'Please select a friendliness<br>';
	}

	// If all is fine
	if ($formValid) {
		// Get the necessary IDs
		$query = 'SELECT cit_id
				  FROM city
				  WHERE cit_name = "'.$city.'"
				';
		$pdoStatement = $pdo->query($query);
		if ($pdoStatement === false) {
			print_r($pdo->errorInfo());
		}
		else {
			$row = $pdoStatement->fetch(PDO::FETCH_ASSOC);
			$city = $row['cit_id'];
		}

		$query = 'SELECT cou_id
				  FROM country
				  WHERE cou_name = "'.$country.'"
				';
		$pdoStatement = $pdo->query($query);
		if ($pdoStatement === false) {
			print_r($pdo->errorInfo());
		}
		else {
			$row = $pdoStatement->fetch(PDO::FETCH_ASSOC);
			$country = $row['cou_id'];
		}

		$query = 'SELECT fri_id
				  FROM friendliness
				  WHERE fri_name = "'.$friendliness.'"
				';
		$pdoStatement = $pdo->query($query);
		if ($pdoStatement === false) {
			print_r($pdo->errorInfo());
		}
		else {
			$row = $pdoStatement->fetch(PDO::FETCH_ASSOC);
			$friendliness = $row['fri_id'];
		}

		$query = 'UPDATE student
				  SET stu_lastname = :st_lastname, stu_firstname = :st_firstname, stu_email = :st_email,
				  	  stu_birthdate = :st_birthdate, friendliness_fri_id = :st_friendliness,
				  	  city_cit_id = :st_city, :st_country = country_cou_id
				  WHERE stu_id = :st_id
				';
		$pdoStatement = $pdo->prepare($query);
		$pdoStatement->bindValue(':st_lastname', $lastname);
		$pdoStatement->bindValue(':st_firstname', $firstname);
		$pdoStatement->bindValue(':st_email', $email);
		$pdoStatement->bindValue(':st_birthdate', $birthdate);
		$pdoStatement->bindValue(':st_friendliness', $friendliness);
		$pdoStatement->bindValue(':st_city', $city);
		$pdoStatement->bindValue(':st_country', $country);
		$pdoStatement->bindValue(':st_id', $_GET['id']);
		if ($pdoStatement->execute() == false) {
			print_r($pdoStatement->errorInfo());
		}
		else {
			$query = 'SELECT stu_id
					  FROM student
					  WHERE stu_lastname = "'.$lastname.'"
					  AND stu_firstname = "'.$firstname.'"
					  AND stu_email = "'.$email.'"
					';
					  /*AND stu_birthdate = "'.$birthdate.'"*/
			echo $query;
			$pdoStatement = $pdo->query($query);
			if ($pdoStatement === false) {
				print_r($pdo->errorInfo());
			}
			else {
				$row = $pdoStatement->fetch(PDO::FETCH_ASSOC);
				header("Location: http://{$config['site_url']}/student.php?id=".$row['stu_id']);
			}
		}
	}

	exit;
}

require dirname(dirname(__FILE__))."/view/student.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>
