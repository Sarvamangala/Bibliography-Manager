<?php

include("inc/connect.php");
$uname = 'test0dfssd';
$email = "test@sdfdfsfsd.com";
$hash = 'sak';
$insert = $db -> prepare("INSERT INTO User (username, email_id, Password) VALUES (?, ?, ?)");
	$insert -> bindParam(1, $uname);
	$insert -> bindParam(2, $email);
	$insert -> bindParam(3, $hash);
	$insert -> execute();

$insert -> execute();



//$result = $query -> fetchALL(PDO::FETCH_ASSOC);

//var_dump($result);


