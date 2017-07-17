<?php

require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/view/header.php";

// Search
if (isset($_GET)) {
	$search = !empty($_GET['search']) ? $_GET['search'] : '';
	$page = !empty($_GET['page']) ? $_GET['page'] : 1;
	$sessionId = !empty($_GET['tid']) ? $_GET['tid'] : '';
	$sessionName = !empty($_GET['tname']) ? $_GET['tname'] : '';
	// Select page
	if  ($page > 1) {
		$offset = ($page - 1) * 20;
	}
	else {
		$offset = 0;
	}

	// Get the student list and populate the array
	$query = 'SELECT stu_id, stu_lastname AS stu_lname, stu_firstname AS stu_fname,
				 stu_email, cou_name, cit_name, fri_name AS stu_friendliness,
				 stu_birthdate AS birthdate
			  FROM student
			  LEFT OUTER JOIN city ON city.cit_id = student.city_cit_id
			  LEFT OUTER JOIN country ON country.cou_id = city.country_cou_id
			  LEFT OUTER JOIN friendliness ON friendliness.fri_id = student.friendliness_fri_id
			  ';
			  if ($sessionId) {
			  	$query .= 'LEFT OUTER JOIN session ON session.ses_id = student.session_ses_id
			  			   WHERE session_ses_id = :sses_id
			  	';
			  }
			  if ($search) {
			  	$query .= 'WHERE stu_lastname LIKE :st_lastname
						  OR stu_firstname LIKE :st_firstname
						  OR stu_email LIKE :st_email
						  OR cit_name LIKE :st_city
						  ';
			  }
			  else {
			  	$query .= 'LIMIT 20 OFFSET '.$offset.'
				';
			  }

			$pdoStatement = $pdo->prepare($query);
			if ($sessionId) {
				$pdoStatement->bindValue(':sses_id', $sessionId);
			}
			if ($search) {
				$pdoStatement->bindValue(':st_lastname', "%".$search."%");
				$pdoStatement->bindValue(':st_firstname', "%".$search."%");
				$pdoStatement->bindValue(':st_email', "%".$search."%");
				$pdoStatement->bindValue(':st_city', "%".$search."%");
			}
			if ($pdoStatement->execute() == false) {
				print_r($pdoStatement->errorInfo());
			}
			else if ($pdoStatement->rowCount() == 1) {
				$row = $pdoStatement->fetch(PDO::FETCH_ASSOC);
				header("Location: http://{$config['site_url']}/student.php?id=".$row['stu_id']);
			}
			else if ($pdoStatement->rowCount() > 1) {
				$studentList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
				$rowCount = $pdoStatement->rowCount();
			}
}

require dirname(dirname(__FILE__))."/view/list.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>
