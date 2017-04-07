<?php
include("connect.php");


function register($uname, $email, $pass) {
	global $db;

	$hash = hash('md5', $pass);

	$insert = $db -> prepare("INSERT INTO User ( username, email_id, Password) VALUES(?,?,?)");
	$insert -> bindParam(1, $uname);
	$insert -> bindParam(2, $email);
	$insert -> bindParam(3, $hash);
	$insert -> execute();

	if($insert) {
		return true;
	}
}


function isLoggedIn() {
	return (isset($_SESSION['user_id']) && $_SESSION['logged_in'] == true);

}

function logIn($username, $password) {
	session_start();
	global $db;
	$q = $db -> prepare("SELECT u.id, u.Password FROM User u WHERE u.username = ?");
	$q -> bindParam(1, $username);
	$q -> execute();
	$result = $q -> fetch(PDO::FETCH_ASSOC);
	//alert('here');

	if(validate($password, $result['Password'])) {
		$_SESSION['uname'] = $username;
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $result['id'];
		return true;
	}
	return $result;

}
// changing password
function changePassword($current_password, $new_password) {
	session_start();
	global $db;
	$q = $db -> prepare("SELECT u.id, u.Password FROM User u WHERE u.username = ?");
	$q -> bindParam(1, $username);
	$q -> execute();
	$result = $q -> fetch(PDO::FETCH_ASSOC);
	//alert('here');

	if(validate($password, $result['Password'])) {
		$_SESSION['uname'] = $username;
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $result['id'];
		return true;
	}
	return $result;

}

function validate($plain, $hash) {

	$thisHash = hash('md5', $plain);
	//echo "this ".$thisHash;
	//echo "<br>that ".$hash;
	return $thisHash === $hash;
}

function logout() {
	$_SESSION = array();
	session_destroy();
	//window.location.replace("login.php");
	//document.location = "login.php";
}