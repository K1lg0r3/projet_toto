<?php

require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/inc/functions.php";
require dirname(dirname(__FILE__))."/view/header.php";

if (!isset($_SESSION["userId"] || $_SESSION["userRole"] != "admin") {
	header("location: http://kilgore.dev/403.php");
}

// ##### UPDATE #####
if (!empty($_POST)) {
	// Get data
	$lastname = isset($_POST['studentName']) ? strip_tags(strtoupper(trim($_POST['studentName']))) : '';
	$firstname = isset($_POST['studentFirstname']) ? strip_tags(trim($_POST['studentFirstname'])) : '';
	$email = isset($_POST['studentEmail']) ? filter_var(filter_input(INPUT_POST, 'studentEmail', FILTER_VALIDATE_EMAIL), FILTER_SANITIZE_EMAIL) : '';
	$birthdate = isset($_POST['studentBirhtdate']) ? strip_tags(trim($_POST['studentBirhtdate'])) : '';
	$city = isset($_POST['cit_id']) ? strip_tags(trim($_POST['cit_id'])) : '';
	$country = isset($_POST['cou_id']) ? strip_tags(trim($_POST['cou_id'])) : '';
	$friendliness = isset($_POST['stu_friendliness']) ? strip_tags(trim($_POST['stu_friendliness'])) : '';
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

	// Upload photo
	if (!empty($_FILES)) {
		foreach ($_FILES as $inputName => $fileData) {
			$tempExplode = explode(".", $fileData["name"]);
			$extension = end($tempExplode);
			if ($extension != "jpg") {
				echo "Wrong file type";
			}
			else {
				$uploadedFilename = __UPLOAD_DIR__.md5("Söme%Cräzy$àlt".$fileData["name"]).".".$extension;
			}
		}
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

		$query = 'INSERT INTO student 
				  (stu_lastname, stu_firstname, stu_email, stu_birthdate, friendliness_fri_id, city_cit_id, country_cou_id, stu_photo) 
				  VALUES (:st_lastname, :st_firstname, :st_email, :st_birthdate, :st_friendliness, :st_city, :st_country, :st_photo)
				';
		$pdoStatement = $pdo->prepare($query);
		$pdoStatement->bindValue(':st_lastname', $lastname);
		$pdoStatement->bindValue(':st_firstname', $firstname);
		$pdoStatement->bindValue(':st_email', $email);
		$pdoStatement->bindValue(':st_birthdate', $birthdate);
		$pdoStatement->bindValue(':st_friendliness', $friendliness);
		$pdoStatement->bindValue(':st_city', $city);
		$pdoStatement->bindValue(':st_country', $country);
		$pdoStatement->bindValue(':st_photo', $uploadedFilename);
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
}

// ##### VIEW #####

// Get cities
$citiesList = getCities();

// Get countries
$countriesList = getCountries();

// Get friendliness
$friendlinessList = getFriendliness();

require dirname(dirname(__FILE__))."/view/add.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>