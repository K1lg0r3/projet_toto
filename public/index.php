<?php


require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/view/header.php";

if (!isset($_SESSION["userId"])) {
	header("location: http://kilgore.dev/signin.php");
}

if (isset($_GET)) {
	$page = !empty($_GET['page']) ? $_GET['page'] : 1;
	// Select page
	if  ($page > 1) {
		$offset = ($page - 1) * 20;
	}
	else {
		$offset = 0;
	}
	$query = 'SELECT ses_id, ses_start_date, ses_end_date, ses_number, tra_name 
			  FROM session
			  LEFT OUTER JOIN training ON training.tra_id = session.training_tra_id 
			  ORDER BY ses_number ASC
			  LIMIT 20 OFFSET '.$offset.'
			  ';

		$pdoStatement = $pdo->prepare($query);

		if ($pdoStatement->execute() == false) {
			print_r($pdoStatement->errorInfo());
		}
		else {
			$trainingList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
			$rowCount = $pdoStatement->rowCount();
		}
}

require dirname(dirname(__FILE__))."/view/home.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>
