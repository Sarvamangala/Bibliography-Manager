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
      ?>

      </a>
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

  <div class="navbar-inverse">
      <div class="navbar-collapse collapse">
        <div class="btn-group pull-right ">
          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-labelledby="dropdownMenuButton">
            Folder
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">All</a></br>
            <a class="dropdown-item" href="#">Trash</a></br>
            <a class="dropdown-item" href="#">Unfiled</a></br>
          </div>
        </div>
      </div>
  </div>
  <div></br></br></br>
  </div>

  <div class="panel panel-login ">
        <form class="form-horizontal" id="changePassword-form" name = "changePassword-form" action="#" method="post" role="form">
        <fieldset>

        <!-- Form Name -->
        <h1>Change Password</h1>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="piCurrPass">Type your current password</label>
          <div class="col-md-4">
            <input id="CurrPass" name="CurrPass" type="password" placeholder="" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="piNewPass">Type your new password</label>
          <div class="col-md-4">
            <input id="NewPass" name="NewPass" type="password" placeholder="" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="piNewPassRepeat">Retype your new password</label>
          <div class="col-md-4">
            <input id="NewPassRepeat" name="NewPassRepeat" type="password" placeholder="" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="bCancel"></label>
          <div class="col-md-4 text-center">

            <input type="submit" id="submit" name="submit" class="btn btn-success" value="Save" onClick="return formvalidationReset();">
          </div>
        </div>

        </fieldset>
        </form>
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

</div>

</body>

<script type="text/javascript">
    //---------------------------------------------change password request
      function formvalidationReset() {
       $("#changePassword-form").validate({
       rules: {
       CurrPass: "required",
              NewPass: "required",
              NewPassRepeat: {
                required: true,
                equalTo: "#password"
              }
      },
      messages: {
              CurrPass: "Please enter your current passowrd.",
              NewPass: "Please enter your new password.",
              NewPassRepeat: {
                required: "Please provide your new password again.",
                equalTo: "Your passwords & confirm password does not match.",
              }
            },
      
      });
    } 

      


    </script>

</html>