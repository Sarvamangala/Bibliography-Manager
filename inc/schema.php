<?php
//include("connect.php");

function setupTables() {
			global $db;

			$createUser = $db -> prepare("CREATE TABLE IF NOT EXISTS 
				User(
				id INT(11) NOT NULL AUTO_INCREMENT,
				username VARCHAR(45) DEFAULT NULL,
				email_id VARCHAR(110) DEFAULT NULL,
				Password VARCHAR(45),
				PRIMARY KEY (id))");
			$createUser -> execute();

			$createRefs = $db -> prepare("CREATE TABLE IF NOT EXISTS 
				refs(
				id INT(11) NOT NULL AUTO_INCREMENT,
				title VARCHAR(145) DEFAULT NULL,
				author VARCHAR(145) DEFAULT NULL,
				date_added VARCHAR(145) DEFAULT NULL,
				date_published VARCHAR(145) DEFAULT NULL,
				volume VARCHAR(145) DEFAULT NULL,
				pages INT(11) NOT NULL,
				user_id INT(11) NOT NULL,
				abstract VARCHAR(145) DEFAULT NULL,
				trash INT(4) NOT NULL,
				PRIMARY KEY (id))");
			$createRefs -> execute();

			$createFolder = $db -> prepare("CREATE TABLE IF NOT EXISTS 
				folders(
				id INT(11) NOT NULL AUTO_INCREMENT,
				name VARCHAR(145) DEFAULT NULL,
				user_id INT(11) NOT NULL,
				ref_id INT(11) NOT NULL,
				PRIMARY KEY (id))");
			$createFolder -> execute();

			}

setupTables();
