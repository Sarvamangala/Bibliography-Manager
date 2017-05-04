
    $('.useracc').click( function (e) {
        e.preventDefault();
        var opt = $(this).attr('id');
        if(opt = 'cpass') {
        window.location.href = "changePassword.php";
        }
        if(opt = 'home') {
        window.location.href = "index.php";
        }
        if(opt = 'logout') {

          //include php functions
        window.location.href = "login.php";
        }
        
    });
    $('.folder').click( function (e) {
        e.preventDefault();
        var folder = $(this).attr('id');
        window.location.href = "index.php?folder="+folder;
        
    });
    
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

  $('#login-form').submit( function (e){

      e.preventDefault();       
        $info = $(this).serializeArray();

      var request = $.ajax({
        url: "ajax/attemptLogin.php",
        method: "POST",
        data: $info,
        dataType: "html"
      });
       
      request.done(function( msg ) {
        console.log(msg);
        if(msg == 'true') {
          window.location.href = "index.php";
        } else if(msg == 'false') {
          alert('The details you have entered are incorrect!');
        }
      });

      request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
      });
      });



      $('#register-form').submit( function (e){

      e.preventDefault();       
        $info = $(this).serializeArray();
        console.log($info);

      var request1 = $.ajax({
        url: "ajax/attemptRegister.php",
        method: "POST",
        data: $info,
        dataType: "html"
      });
       
      request1.done(function( msg ) {
        if(msg == 'true') {
          location.reload();
        } else if(msg == 'false') {
          alert('Ooops! Something went wrong!');
        }
      });
       
      request1.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
      });
      });
    
