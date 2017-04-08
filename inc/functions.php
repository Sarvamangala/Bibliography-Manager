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

	/*$q = $db -> prepare("SELECT u.id, u.Password FROM User u WHERE u.username = ?");
	$q -> bindParam(1, $_SESSION['uname']);
	$q -> execute();
	$result = $q -> fetch(PDO::FETCH_ASSOC);
	//alert('here');
	echo $result['Password']." ";
	$thisHash =  hash('md5', $current_password);
	echo $thisHash;*/
	/*if(hash('md5', $current_password), $result['Password']) {
		echo "herer !";
	}*/


	$query = $db -> prepare("UPDATE User SET Password = :newPassword WHERE id = :id AND Password = :currentPassword");
	$query->bindParam(':newPassword', hash('md5', $new_password));
	$query->bindParam(':id', $_SESSION['user_id']);
    $query->bindParam(':currentPassword', hash('md5', $current_password));
    $query->execute();

	$count = $query->rowCount();

	if($count ==0){
    return false;
	}
	else{
    return true;
	}
}

function validate($plain, $hash) {

	$thisHash = hash('md5', $plain);
	//echo "this ".$thisHash;
	//echo "<br>that ".$hash;
	return $thisHash === $hash;
}

function logout() {
	$_SESSION['logged_in'] = false;

	$_SESSION = array();
	session_destroy();
	//window.location.replace("login.php");
	//document.location = "login.php";
}

function create_trash($user_id) {

	global $db;

	$q = $db -> prepare("CREATE TABLE IF NOT EXISTS folders(
	  	id INT(11) NOT NULL AUTO_INCREMENT,
	  	name VARCHAR(45) DEFAULT NULL,
	  	user_id INT(10),
	  	PRIMARY KEY (id))");

	$check_for_trash = $db -> prepare("SELECT f.id FROM folders f WHERE f.name = ? AND f.user_id = ? LIMIT 1");
	$check_for_trash -> bindValue(1, 'trash');
	$check_for_trash -> bindParam(2, $user_id);
	$check_for_trash -> execute();
	$result = $check_for_trash -> fetch(PDO::FETCH_ASSOC);

	if(!isset($result['id'])) {	//Don't create the trash folder if it already exists for this user

		$insert = $db -> prepare("INSERT INTO folders(name, user_id) VALUES (?, ?)");
		$insert -> bindValue(1,'trash');
		$insert -> bindParam(2, $user_id);
		$insert -> execute();

	}

	$check_for_unfiled = $db -> prepare("SELECT f.id FROM folders f WHERE f.name = ? AND f.user_id = ? LIMIT 1");
	$check_for_unfiled -> bindValue(1, 'unfiled');
	$check_for_unfiled -> bindParam(2, $user_id);
	$check_for_unfiled -> execute();
	$result = $check_for_unfiled -> fetch(PDO::FETCH_ASSOC);

	if(!isset($result['id'])) {	//Don't create the trash folder if it already exists for this user

		$insert = $db -> prepare("INSERT INTO folders(name, user_id) VALUES (?, ?)");
		$insert -> bindValue(1,'unfiled');
		$insert -> bindParam(2, $user_id);
		$insert -> execute();

	}

	return;

}