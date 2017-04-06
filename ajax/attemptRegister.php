<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo register($_POST['username'], $_POST['email'], $_POST['password']) ? 'true' : 'false';