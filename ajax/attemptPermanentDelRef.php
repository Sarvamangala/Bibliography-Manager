<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo delPermanentRef($_POST['delref']) ? 'true' : 'false';