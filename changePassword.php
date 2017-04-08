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
</br></br></br></br></br></br>
<div class = "container ">

  
  <div class="col-sm-3 col-md-3 col-lg-3"></br></br></br>
  </div>

  <div class="panel panel-login col-sm-6 col-md-6 col-lg-6">
        <form class="form-horizontal" id="changePassword-form" name = "changePassword-form" action="#" method="post" role="form">
        <fieldset>

        <!-- Form Name -->
        <div>

        <div class="col-sm-2 col-md-2 col-lg-2">
        
        </div>
        <h1 class="col-sm-10 col-md-10 col-lg-10">Change Password</h1>
        </div>
        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="piCurrPass">Type your current password</label>
          <div class="col-md-6">
            <input id="CurrPass" name="CurrPass" type="password" placeholder="" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="piNewPass">Type your new password</label>
          <div class="col-md-6">
            <input id="NewPass" name="NewPass" type="password" placeholder="" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="piNewPassRepeat">Retype your new password</label>
          <div class="col-md-6">
            <input id="NewPassRepeat" name="NewPassRepeat" type="password" placeholder="" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="bCancel"></label>
          <div class="col-md-4 text-center">

            <input type="submit" id="submit" name="submit" class="btn btn-success" value="Save" >
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
    

  $(document).ready(function () {

     $('.submit').click(function(){
        validateForm();   
    });

  function validateForm(){


    var currpassword = $('#CurrPass').val();
    var newpassword = $('#NewPass').val();
    var renewpassword = $('#NewPassRepeat').val();
    

    var inputVal = new Array(currpassword, newpassword, renewpassword);

    var inputMessage = new Array("name", "company", "email address", "telephone number", "message");

     

        if(inputVal[0] == ""){
            $('#nameLabel').after('<span class="error"> Please enter your ' + inputMessage[0] + '</span>');
        } 
       
                if(inputVal[1] == ""){
            $('#companyLabel').after('<span class="error"> Please enter your ' + inputMessage[1] + '</span>');
        }

        if(inputVal[2] != inputVal[1]){
            $('#emailLabel').after('<span class="error"> Please enter your ' + inputMessage[2] + '</span>');
            console.log("msg");
        } 
        
  }
});   

  $('#changePassword-form').submit( function (e){

      e.preventDefault();       
        $info = $(this).serializeArray();

      var request = $.ajax({
        url: "ajax/attemptChangePassword.php",
        method: "POST",
        data: $info,
        dataType: "html"
      });
       
      request.done(function( msg ) {
        //console.log(msg);
        if(msg == 'true') {
          alert('Your password has been successfully changed. Cheers!');
          window.location.href = "index.php";
        } else if(msg == 'false') {
          alert('The details you have entered are incorrect!');
        }
      });

      request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
      });
      });

    </script>

</html>