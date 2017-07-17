<?php

require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/view/header.php";

if (isset($_POST) && !empty($_POST["emailReset"])) {
	$sql = '
		SELECT *
		FROM user
		WHERE usr_email = :email
	';
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':email', $_POST["emailReset"]);

	if ($pdoStatement->execute() === false) {
		print_r($pdoStatement->errorInfo());
	}
	else {
			if ($pdoStatement->rowCount() > 0) {
				$userData = $pdoStatement->fetch(PDO::FETCH_ASSOC);
				$_SESSION["userId"] = $userData["usr_id"];
				echo 'If '.$_POST["emailReset"].' is a valid e-mail a message has been sent to it with the procedure to reset its password.<br>';
				$token = md5($userData["usr_id"].md5(microtime().getmypid() * rand(348, 697425)));
				$sql = '
					UPDATE user
					SET usr_token = "'.$token.'"
					WHERE usr_id = "'.$userData["usr_id"].'"
				';
				$pdoStatement = $pdo->prepare($sql);
				if ($pdoStatement->execute() === false) {
					print_r($pdoStatement->errorInfo());
				}
				else {
					require dirname(dirname(__FILE__))."/vendor/autoload.php";
					$mail = new PHPMailer;
					$mail->SMTPDebug = 0;                               // Enable verbose debug output
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.live.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'armand.denis@hotmail.com';                 // SMTP username
					$mail->Password = file_get_contents(dirname(dirname(__FILE__)).'/inc/pwd.txt');                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    // TCP port to connect to
					$mail->setFrom('armand.denis@hotmail.com', 'Kilgore Trout');
					$mail->addAddress('armand.denis@hotmail.com', 'Kilgore Trout');     // Add a recipient
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = 'Reset Password';
					$mail->Body    = 'Click the following link to reset your password:<br><a href="http://kilgore.dev/reset_password.php?token='.$token.'">Click here to reset your password</a>';
					$mail->AltBody = 'SET LATER';

					if(!$mail->send()) {
					    echo 'Message could not be sent.';
					    echo 'Mailer Error: ' . $mail->ErrorInfo;
					} else {
					    echo 'Message has been sent';
					}
				}
			}
		 }
}

require dirname(dirname(__FILE__))."/view/forgot_password.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>