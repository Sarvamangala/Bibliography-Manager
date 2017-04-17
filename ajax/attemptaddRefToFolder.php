<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo attemptaddRefToFolder($_GET['pickfolder'], $_POST['checkArray']) ? 'true' : 'false';
//echo 'true';