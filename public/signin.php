<?php

require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/inc/functions.php";
require dirname(dirname(__FILE__))."/view/header.php";

// Si formulaire soumis
if (!empty($_POST)) {
	//print_r($_POST);exit;
	// Récupération & traitement des données
	$email = isset($_POST['emailToto']) ? strip_tags(trim($_POST['emailToto'])) : '';
	$password = isset($_POST['passwordToto1']) ? trim($_POST['passwordToto1']) : '';

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

	if (empty($password)) {
		$formValid = false;
		$errorList['passwordToto'][] = 'Le password est vide';
	}
	if (strlen($password) < 6) {
		$formValid = false;
		$errorList['passwordToto'][] = 'Le password doit faire au moins 6 caractères';
	}

	// Si tout est ok
	if ($formValid) {
		$sql = '
			SELECT *
			FROM user
			WHERE usr_email = :email
		';
		$pdoStatement = $pdo->prepare($sql);
		// bindValues
		$pdoStatement->bindValue(':email', $email);
		// Clear password
		//$pdoStatement->bindValue(':password', $password);
		// md5
		//$pdoStatement->bindValue(':password', md5($password));
		// md5 + salt
		// $pdoStatement->bindValue(':password', md5('sdgh¨è234'.$password));

		// execution
		if ($pdoStatement->execute() === false) {
			print_r($pdoStatement->errorInfo());
		}
		else {
			if ($pdoStatement->rowCount() > 0) {
				$userData = $pdoStatement->fetch(PDO::FETCH_ASSOC);
				if (password_verify($password, $userData["usr_password"]) === true) {
					$_SESSION["userId"] = $userData["usr_id"];
					$_SESSION["sessionId"] = session_id();
					$_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];
					$_SESSION["userRole"] = $userData["usr_role"];
					echo 'Utilisateur connecté<br>';
					header("location: http://kilgore.dev/index.php");
				}
				else {
					echo 'Email/Password non reconnus<br>';
				}
			}
		}
	}
}

require dirname(dirname(__FILE__))."/view/signin.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>
