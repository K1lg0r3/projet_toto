<?php

require dirname(__FILE__)."/db.php";

// Function to validate a date format: Shamelessly ripped off php.net.
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


function getCities() {
	global $pdo;
	$list = array();
	$query = 'SELECT cit_name
			  FROM city
			';
	$pdoStatement = $pdo->query($query);
	if ($pdoStatement === false) {
		print_r($pdo->errorInfo());
	}
	while (($row = $pdoStatement->fetch(PDO::FETCH_ASSOC))) {
		$list[] = $row['cit_name'];
	}
	return $list;
}

function getCountries() {
	global $pdo;
	$list = array();
	$query = 'SELECT cou_name
			  FROM country
			';
	$pdoStatement = $pdo->query($query);
	if ($pdoStatement === false) {
		print_r($pdo->errorInfo());
	}
	while (($row = $pdoStatement->fetch(PDO::FETCH_ASSOC))) {
		$list[] = $row['cou_name'];
	}
	return $list;
}

function getFriendliness() {
	global $pdo;
	$list = array();
	$query = 'SELECT fri_name
			  FROM friendliness
			';
	$pdoStatement = $pdo->query($query);
	if ($pdoStatement === false) {
		print_r($pdo->errorInfo());
	}
	while (($row = $pdoStatement->fetch(PDO::FETCH_ASSOC))) {
		$list[] = $row['fri_name'];
	}
	return $list;
}

function sendMail($host, $username, $password , $sender, $senderName, $recipient, $debug = 0) {
	require "vendor/autoload.php";

	$mail = new PHPMailer;

	$mail->SMTPDebug = $debug;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $host;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $username;                 // SMTP username
	$mail->Password = $password;                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom($sender, $senderName);
	// $mail->addAddress($recipient, $recipientName);     // Add a recipient
	$mail->addAddress($recipient);               // Name is optional
	// $mail->addReplyTo('vassili.simon@gmail.com', 'Vassili');
	// $mail->addCC('cc@example.com');
	// $mail->addBCC('bcc@example.com');

	// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Test';
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo 'Message has been sent';
	}
}

?>