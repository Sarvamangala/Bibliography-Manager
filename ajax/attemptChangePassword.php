<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo changePassword($_POST['CurrPass'], $_POST['NewPass']) ? 'true' : 'false';