<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo login($_POST['username'], $_POST['password']) ? 'true' : 'false';