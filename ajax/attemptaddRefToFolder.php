<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo addRefToFolder($_GET['pickfolder'], $_POST['checkArray']) ? 'true' : 'false';
//echo 'true';