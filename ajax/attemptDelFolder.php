<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo delFolder($_POST['delfolder']) ? 'true' : 'false';
//echo 'true';