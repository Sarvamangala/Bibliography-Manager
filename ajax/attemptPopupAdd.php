<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo PopupAdd($_POST['title'], $_POST['author'], $_POST['dateCreated'], $_POST['datePublished'], $_POST['volume'], $_POST['abstract'], $_POST['pages']) ? 'true' : 'false';