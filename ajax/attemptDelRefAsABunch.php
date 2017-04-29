<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo attemptDelRefAsABunch($_POST['checkArray']) ? 'true' : 'false';
//echo 'true';