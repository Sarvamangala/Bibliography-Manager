<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo changePassword($_POST['current_password'], $_POST['new_password']) ? 'true' : 'false';