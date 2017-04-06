<?php
session_start();

include("inc/connect.php");
include("inc/functions.php");

if(isset($_POST['logout'])) {
  logout();
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/style.css">

  <script src=js/login.js></script>



</script>
<style>

body {font-family: "Raleway", sans-serif}


.bgimg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-size: cover;
    
    background-image: url('images/bike.jpg');
    
  }
</style>

</head>

<body class="bgimg">



<nav class="navbar navbar-inverse bg-primary">


  <div id="navbar" class="navbar-collapse collapse">
    <div class="col-sm-11 col-md-11 col-lg-11">
      <a class="navbar-brand pull-right" href="#"><?php echo $_SESSION['uname'];
      ?></a>
    </div>
    <div class="col-sm-1 col-md-1 col-lg-1">
      <form id="logout-form" class="navbar-form navbar-right" role="form" method="POST">
      <input type="hidden" name="logout" value="true">
      <button type="submit" id="logout" class="btn btn-danger">Sign Out</button>
      </form>
    </div>   
  </div>  
</nav>

<div class = "container">

<div >
  <div class="btn-group pull-right">
    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-labelledby="dropdownMenuButton">
      Folder
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#">All</a></br>
      <a class="dropdown-item" href="#">Trash</a></br>
    </div>
  </div>
</div>


    <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>title</th>
        <th>author</th>
        <th>date added</th>
        <th>date published</th>
        <th>volume</th>
        <th>abstact</th>
        <th>pages</th>
    </tr>
  </thead>
  <tbody>
    <?php


      $q = $db -> prepare("SELECT r.* FROM refs r WHERE r.user_id = ?");
      $q -> bindParam(1, $_SESSION['user_id']);
      $q -> execute();
      $results = $q -> fetchAll(PDO::FETCH_ASSOC);

      foreach($results as $row) { ?>
      <tr>
        <td><?=$row['title']?></td>
        <td><?=$row['author']?></td>
        <td><?=$row['date_added']?></td>
        <td><?=$row['date_published']?></td>
        <td><?=$row['volume']?></td>
        <td><?=$row['abstract']?></td>
        <td><?=$row['pages']?></td>
     </tr>
       <?php } ?>
       </tbody>
    </table>

    

</div>
</body>
  