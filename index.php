<?php
include("inc/header.php");
?>

<?php 

      if (isset($_SESSION["uname"])) { ?>
<nav class="navbar navbar-inverse bg-primary">
  <div id="navbar" class="navbar-collapse collapse">
    <div class="col-sm-11 col-md-11 col-lg-11">
      <a class="navbar-brand pull-right" href="#"><?php 

      //can eliminate this!
      if (isset($_SESSION["uname"])) {
      echo $_SESSION['uname'];   
      }
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

  <div class="bg-warning">
    <div class="navbar-collapse collapse">
      <div class="btn-group pull-right ">

        <select id="folders" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-labelledby="dropdownMenuButton">
        <div class="dropdown-menu">
        <option class="dropdown-item" value="" default>Select one</option>
        <option class="dropdown-item" value="all" default>All</option>
        <option class="dropdown-item" value="trash">trash</option>
        <option class="dropdown-item" value="unfiled">unfiled</option>
        </select>
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


      if(isset($_GET['folder']) && $_GET['folder'] != 'all') {
        $q = $db -> prepare("SELECT r.* FROM refs r INNER JOIN folders f ON r.user_id = f.user_id 
            WHERE r.user_id = ? AND f.name = ? AND r.user_id = f.user_id AND r.id = f.ref_id");

        $q -> bindParam(1, $_SESSION['user_id']);
        $q -> bindParam(2, $_GET['folder']);
        $q -> execute();
        $results = $q -> fetchAll(PDO::FETCH_ASSOC);
         } else {

        $q = $db -> prepare("SELECT r.* FROM refs r WHERE r.user_id = ?");
        $q -> bindParam(1, $_SESSION['user_id']);
        $q -> execute();
        $results = $q -> fetchAll(PDO::FETCH_ASSOC);
        }

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

    <button id="modal-button" type="button" class="btn btn-danger btn-info pull-right">Add new</button>

    <?php } else { ?>

            <nav class="navbar navbar-inverse bg-primary">
            <div id="navbar" class="navbar-collapse collapse">
            <div class="col-md-3 "></div>
            <div class="col-md-9 ">
                <h1>You are not logged in. Please <a href="login.php">login</a> here</h1>
            </div>
            
            </div>
            </nav>

    <?php } ?>

</div>
</body>

<script type="text/javascript">
    $('#folders').change( function (e) {
        e.preventDefault();
        var folder = $(this).val();
        window.location.href = "index.php?folder="+folder;
        
    });
</script>
  