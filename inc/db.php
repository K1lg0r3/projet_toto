<?php

$dsn = "mysql:dbname={$config['db_database']};host={$config['db_host']};charset=UTF8";

try {
	$pdo = new PDO($dsn, $config['db_user'], $config['db_password']);
	// For debugging
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
	echo $e->getMessage();
}



?>