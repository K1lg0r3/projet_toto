<?php

require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/inc/functions.php";
require dirname(dirname(__FILE__))."/view/header.php";

// Initialisations
$successTxt = '';
$errorList = array();
$email = '';

if (!empty($_POST)) {
	// Récupération & Traitement des données
	$email = isset($_POST['emailToto']) ? strip_tags(trim($_POST['emailToto'])) : '';
	$password1 = isset($_POST['passwordToto1']) ? trim($_POST['passwordToto1']) : '';
	$password2 = isset($_POST['passwordToto2']) ? trim($_POST['passwordToto2']) : '';

	// Validation des données
	$formValid = true;

	if (empty($email)) {
		$formValid = false;
		$errorList['emailToto'][] = 'L\'email est vide';
	}
	else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		$formValid = false;
		$errorList['emailToto'][] = 'L\'email est invalide';
	}

	if (empty($password1) || empty($password2)) {
		$formValid = false;
		$errorList['passwordToto'][] = 'Le password est vide';
	}
	if ($password1 !== $password2) {
		$formValid = false;
		$errorList['passwordToto'][] = 'Les password sont différents';
	}
	if (strlen($password1) < 6 || strlen($password2) < 6) {
		$formValid = false;
		$errorList['passwordToto'][] = 'Le password doit faire au moins 6 caractères';
	}

	// Si tout est ok => on ajoute en DB
	if ($formValid) {
		$sql = "
			INSERT INTO user (usr_email, usr_password, usr_date_creation)
			VALUES (:email, :password, NOW())
		";

		// Prepare la requete
		$pdoStatement = $pdo->prepare($sql);
		// bindValues
		$pdoStatement->bindValue(':email', $email);
		// Clear password
		$hashedPassword = password_hash($password1, PASSWORD_BCRYPT);
		// md5
		//$hashedPassword = md5($password1);
		// md5 + salt
		//$hashedPassword = md5('salt à_moi:)'.$password1);

		$pdoStatement->bindValue(':password', $hashedPassword);

		// Execution
		if ($pdoStatement->execute() === false) {
			print_r($pdoStatement->errorInfo());
		}
		// Si aucun erreur SQL
		else {
			$successTxt = 'Votre inscription a bien été prise en compte';
		}
	}
}

require dirname(dirname(__FILE__))."/view/signup.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>
