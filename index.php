<?php
include("inc/header.php");
?>

<?php 

      if (isset($_SESSION["uname"])) { ?>
<nav class="navbar navbar-inverse bg-primary">
   
<div class="dropdown navbar-brand pull-right">

  <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    
    <?php 

      //can eliminate this!
      if (isset($_SESSION["uname"])) {
      echo $_SESSION['uname'];   
      }
      ?>

    <!-- Display icon in button -->
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <!-- Unselectable header -->
    <li><a href="#" id="cPass" class="dropdown-item useracc">Change Password</a></li>
    <li><a href="#" id="logout" class="dropdown-item useracc">Logout</a></li>
  </ul>

</div>
</nav>

<div class = "container " >

  
    <div class="navbar-collapse collapse">
      <div class="btn-group pull-right ">

        <button id="folders" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-labelledby="dropdownMenuButton">Folders
        <span class="caret"></span>
         </button>
        <div class="dropdown-menu">
        <li><a href="#" id="all" class="dropdown-item folder">All</a></li>  
        <?php
      $q = $db -> prepare("SELECT DISTINCT name FROM `folders` WHERE user_id = ?");
      $q -> bindParam(1, $_SESSION['user_id']);
      $q -> execute();
      $results = $q -> fetchAll(PDO::FETCH_ASSOC);
         
      foreach($results as $row) { ?>
        <li><a href="#" id=<?=$row['name']?> class="dropdown-item folder"><?=$row['name']?>
        <?php if ($row['name'] != 'trash' && $row['name'] != 'unfiled') { ?>
          <span class="glyphicon glyphicon-trash delfolder pull-right" id=<?=$row['name']?>></span>
        <?php } ?>
        </a></li>
       <?php } ?>
       <div class="input-group">
            <input type="text" class="form-control" id="newfolder" name="newfolder" placeholder="New Folder?">
            <span class="input-group-addon addfolder"><span class="glyphicon glyphicon-plus addfolder"></span></span>
          </div>
        </div>
      </div>

      <div class="btn-group">
        <button id="folders" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-labelledby="dropdownMenuButton">Move To
        <span class="caret"></span>
         </button>
        <div class="dropdown-menu">
        <?php
      $q = $db -> prepare("SELECT DISTINCT name FROM `folders` WHERE user_id = ?");
      $q -> bindParam(1, $_SESSION['user_id']);
      $q -> execute();
      $results = $q -> fetchAll(PDO::FETCH_ASSOC);   
      foreach($results as $row) { if(isset($_GET['folder']) && $_GET['folder'] != $row['name'] || !isset($_GET['folder'])){ ?>
        <li><a href="#" id=<?=$row['name']?> class="dropdown-item pickfolder"><?=$row['name']?></a></li>
       <?php } } if(isset($_GET['folder']) && $_GET['folder'] == 'trash'){ ?>
        <li><a href="#" id='PermanentDelete' class="dropdown-item pickfolder">Permanent Delete</a></li> <?php }?>
          
        </div>
      </div>
    </div>
    


    <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th></th>
        <th>Title</th>
        <th>Author</th>
        <th>Date added</th>
        <th>Date published</th>
        <th>Volume</th>
        <th>Abstact</th>
        <th>Pages</th>
    </tr>
  </thead>
  <tbody>
  <form>
    <?php


      if(isset($_GET['folder']) && $_GET['folder'] != 'all') {
        $q = $db -> prepare("SELECT r.* FROM refs r INNER JOIN folders f ON r.user_id = f.user_id 
            WHERE r.user_id = ? AND f.name = ? AND r.user_id = f.user_id AND r.id = f.ref_id");

        $q -> bindParam(1, $_SESSION['user_id']);
        $q -> bindParam(2, $_GET['folder']);
        $q -> execute();
        $results = $q -> fetchAll(PDO::FETCH_ASSOC);
         } else {

        $q = $db -> prepare("SELECT r.* FROM refs r WHERE r.user_id = ? AND r.trash = 0");
        $q -> bindParam(1, $_SESSION['user_id']);
        $q -> execute();
        $results = $q -> fetchAll(PDO::FETCH_ASSOC);
        }
      foreach($results as $row) { ?>
      <tr>
        <td><div id="c_b"><input type="checkbox" class="check" name="check" value=<?=$row['id']?>></div></td>
        <td><?=$row['title']?></td>
        <td><?=$row['author']?></td>
        <td><?=$row['date_added']?></td>
        <td><?=$row['date_published']?></td>
        <td><?=$row['volume']?></td>
        <td><?=$row['abstract']?></td>
        <td><?=$row['pages']?></td>
        <?php if(true){ ?>
        <td><span class="glyphicon glyphicon-trash delref pull-right" id=<?=$row['id']?>></span></td>
        <?php } ?>
     </tr>
       <?php } ?>
       </form>
       </tbody>
       </tbody>
    </table>

  

  

<div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
    <a href="#myModal" class="btn btn-danger btn-info pull-right" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> new </a>
    
    
    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Enter The Journal Details</h4>
                </div>
                <div class="modal-body">
                    <form id="popup" name="popup" action="#" method="post" role="form">
                        <div class="form-group">
                            <label for="inputName">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Author</label>
                            <input type="text" class="form-control" id="inputName" id="author" name="author">
                        </div>
                        <div class="form-group">
                          <label for="inputName">Date Created</label>
                          <div class="">
                          <div id="datetimepicker1" class="input-group date">
                            <input type="text" class="form-control" id="dateCreated" name="dateCreated">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>
                       </div>
                         <div class="form-group">
                            <label for="inputName">Date Published</label>
                            <div class="">
                            <div id="datetimepicker2" class="input-group date">
                              <input type="text" class="form-control" id="datePublished" name="datePublished">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </div>
                         </div>
                        <div class="form-group">
                            <label for="inputComment">Volume</label>
                            <textarea class="form-control" id="volume" name="volume" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputComment">Abstract</label>
                            <textarea class="form-control" id="abstract" name="abstract" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Pages</label>
                            <input type="text" class="form-control" id="pages" name="pages">
                        </div>
                    
                
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <input type="submit" name="add" id="login-submit" tabindex="4" class="btn btn-danger" value="Add">
                  </div>
                  </form>
              </div>
          </div>
      </div>
</div>  


</div>  
</div>  

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


</body>

<script type="text/javascript">
    $('.useracc').click( function (e) {
        e.preventDefault();
        var opt = $(this).attr('id');
        if(opt == 'cPass') {
        window.location.href = "changePassword.php";
        }
        if(opt == 'home') {
        window.location.href = "index.php";
        }
        if(opt == 'logout') {

          $.ajax({
            url: 'ajax/attemptLogout.php',
            type: 'POST',
            data: { "logout": "true"},
            success: function(response) { window.location.href = "login.php"; }
        });
        //window.location.href = "login.php";
        }
        
    });
    $('.folder').click( function (e) {
        e.preventDefault();
        var folder = $(this).attr('id');
        window.location.href = "index.php?folder="+folder;
        
    });
    
$(document).ready(function(){
    $("#myModal").on('shown.bs.modal', function(){
        $(this).find('input[name="title"]').focus();
    }); 

});

$('#popup').submit( function (e){

      e.preventDefault();       
        $info = $(this).serializeArray();

      var request = $.ajax({
        url: "ajax/attemptPopupAdd.php",
        method: "POST",
        data: $info,
        dataType: "html"
      });
       
      request.done(function( msg ) {
        console.log(msg);
        if(msg == 'true') {
          //alert('Your Journal Details has been added successfully')
          window.location.href = "index.php";
        } else if(msg == 'false') {
          alert('SomeThing went wrong, Please try again!');
        }
      });

      request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
      });
  });

$('.pickfolder').click( function (e) {

      e.preventDefault(); 

        var pickfolder = $(this).attr('id');

         var idArray = [];
        $('#c_b :checked').each(function() {
          idArray.push(parseInt($(this).val()));
        });


        if (pickfolder == 'PermanentDelete') {

            if (confirm('Are you sure you want to trash these refs out of the database')) {
                
              var request = $.ajax({
        url: "ajax/attemptDelRefAsABunch.php?",
        method: "POST",
        data: {checkArray : idArray},
        dataType: "html"
      });
       
      request.done(function( msg ) {
        console.log(idArray);
        console.log(msg);
        if(msg == 'true') {
          //alert('inserted!')
          window.location.href = "index.php";
        } else if(msg == 'false') {
          alert('SomeThing went wrong, Please try again!');
        }
      });

            } else {
                alert('Not deleted any')
              window.location.href = "index.php";
            }
      } else {

            var request = $.ajax({
        url: "ajax/attemptaddRefToFolder.php?pickfolder="+pickfolder,
        method: "POST",
        data: {checkArray : idArray},
        dataType: "html"
      });
       
      request.done(function( msg ) {
        console.log(idArray);
        console.log(msg);
        if(msg == 'true') {
          //alert('inserted!')
          window.location.href = "index.php";
        } else if(msg == 'false') {
          alert('SomeThing went wrong, Please try again!');
        }
      });
      

      }

      request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
      

      
  });

$('.delref').click( function (e) {

      e.preventDefault(); 

      var delref = $(this).attr('id');

      var $_GET = {};

      document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
          function decode(s) {
              return decodeURIComponent(s.split("+").join(" "));
          }

          $_GET[decode(arguments[1])] = decode(arguments[2]);
      });

      

      if ($_GET['folder'] == 'trash') {

            if (confirm('Are you sure you want to trash this ref out of the database')) {
                
              var request = $.ajax({
            url: "ajax/attemptPermanentDelRef.php?",
            method: "POST",
            data: {delref : delref},
            dataType: "html"
             });
           
          request.done(function( msg ) {
            console.log(delref);
            console.log(msg);
            if(msg == 'true') {
              alert('Deleted successfully!')
              window.location.href = "index.php";
            } else if(msg == 'false') {
              alert('SomeThing went wrong, Please try again!');
            }
            });

            } else {
                alert('Not deleted any')
              window.location.href = "index.php";
            }
      } else {

            var request = $.ajax({
            url: "ajax/attemptDelRef.php?",
            method: "POST",
            data: {delref : delref},
            dataType: "html"
          });
           
          request.done(function( msg ) {
            console.log(delref);
            console.log(msg);
            if(msg == 'true') {
              alert('Deleted successfully!')
              window.location.href = "index.php";
            } else if(msg == 'false') {
              alert('SomeThing went wrong, Please try again!');
            }
          });

      

      }

      request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
      
  });

// to delete a folder
$('.delfolder').click( function (e) {

      e.preventDefault(); 

        var delfolder = $(this).attr('id');

      var request = $.ajax({
        url: "ajax/attemptDelFolder.php",
        method: "POST",
        data: {delfolder : delfolder},
        dataType: "html"
      });
       
      request.done(function( msg ) {
        //console.log(delfolder);
        //console.log(msg);
        if(msg == 'true') {
          //alert('deleted!')
          window.location.href = "index.php";
        } else if(msg == 'false') {
          alert('SomeThing went wrong, Please try again!');
        }
      });

      request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
      });
  });

$('.addfolder').click( function (e) {

      e.preventDefault(); 

        var newfolder = $('#newfolder').val();

      var request = $.ajax({
        url: "ajax/attemptNewFolder.php?newfolder="+newfolder,
        dataType: "html"
      });
       
      request.done(function( msg ) {
        //console.log(newfolder);
        if(msg == 'true') {
          //alert('New folder created for you!')
          window.location.href = "index.php";
        } else if(msg == 'false') {
          alert('SomeThing went wrong, Please try again!');
        }
      });

      request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
      });
  });

(function(e){function c(e){return e.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&")}function h(e,t,n){if(t<e.length)return e;else return Array(t-e.length+1).join(n||" ")+e}function p(e,t,n,r,i,s){if(t&&n){return'<div class="bootstrap-datetimepicker-widget dropdown-menu" style="z-index:9999 !important;">'+'<ul class="list-unstyled">'+"<li"+(s?' class="collapse in"':"")+">"+'<div class="datepicker">'+v.template+"</div>"+"</li>"+'<li class="picker-switch accordion-toggle"><a class="btn" style="width:100%"><span class="'+e+'"></span></a></li>'+"<li"+(s?' class="collapse"':"")+">"+'<div class="timepicker">'+m.getTemplate(r,i)+"</div>"+"</li>"+"</ul>"+"</div>"}else if(n){return'<div class="bootstrap-datetimepicker-widget dropdown-menu">'+'<div class="timepicker">'+m.getTemplate(r,i)+"</div>"+"</div>"}else{return'<div class="bootstrap-datetimepicker-widget dropdown-menu">'+'<div class="datepicker">'+v.template+"</div>"+"</div>"}}function d(){return new Date(Date.UTC.apply(Date,arguments))}var t=window.orientation!=undefined;var n=function(e,t){this.id=i++;this.init(e,t)};var r=function(e){if(typeof e==="string"){return new Date(e)}return e};n.prototype={constructor:n,init:function(t,n){var r;if(!(n.pickTime||n.pickDate))throw new Error("Must choose at least one picker");this.options=n;this.$element=e(t);this.language=n.language in s?n.language:"en";this.pickDate=n.pickDate;this.pickTime=n.pickTime;this.isInput=this.$element.is("input");this.component=false;if(this.$element.find(".input-group"))this.component=this.$element.find(".input-group-addon");this.format=n.format;if(!this.format){if(this.isInput)this.format=this.$element.data("format");else this.format=this.$element.find("input").data("format");if(!this.format)this.format="MM/dd/yyyy"+(this.pickTime?" hh:mm":"")+(this.pickSeconds?":ss":"")}this._compileFormat();if(this.component){r=this.component.find("span")}if(this.pickTime){if(r&&r.length)this.timeIcon=r.data("time-icon");if(!this.timeIcon)this.timeIcon="glyphicon glyphicon-time";r.addClass(this.timeIcon)}if(this.pickDate){if(r&&r.length)this.dateIcon=r.data("date-icon");if(!this.dateIcon)this.dateIcon="glyphicon glyphicon-calendar";r.removeClass(this.timeIcon);r.addClass(this.dateIcon)}this.widget=e(p(this.timeIcon,n.pickDate,n.pickTime,n.pick12HourFormat,n.pickSeconds,n.collapse)).appendTo("body");this.minViewMode=n.minViewMode||this.$element.data("date-minviewmode")||0;if(typeof this.minViewMode==="string"){switch(this.minViewMode){case"months":this.minViewMode=1;break;case"years":this.minViewMode=2;break;default:this.minViewMode=0;break}}this.viewMode=n.viewMode||this.$element.data("date-viewmode")||0;if(typeof this.viewMode==="string"){switch(this.viewMode){case"months":this.viewMode=1;break;case"years":this.viewMode=2;break;default:this.viewMode=0;break}}this.startViewMode=this.viewMode;this.weekStart=n.weekStart||this.$element.data("date-weekstart")||0;this.weekEnd=this.weekStart===0?6:this.weekStart-1;this.setStartDate(n.startDate||this.$element.data("date-startdate"));this.setEndDate(n.endDate||this.$element.data("date-enddate"));this.fillDow();this.fillMonths();this.fillHours();this.fillMinutes();this.fillSeconds();this.update();this.showMode();this._attachDatePickerEvents()},show:function(e){this.widget.show();this.height=this.component?this.component.outerHeight():this.$element.outerHeight();this.place();this.$element.trigger({type:"show",date:this._date});this._attachDatePickerGlobalEvents();if(e){e.stopPropagation();e.preventDefault()}},disable:function(){this.$element.find("input").prop("disabled",true);this._detachDatePickerEvents()},enable:function(){this.$element.find("input").prop("disabled",false);this._attachDatePickerEvents()},hide:function(){var e=this.widget.find(".collapse");for(var t=0;t<e.length;t++){var n=e.eq(t).data("collapse");if(n&&n.transitioning)return}this.widget.hide();this.viewMode=this.startViewMode;this.showMode();this.$element.trigger({type:"hide",date:this._date});this._detachDatePickerGlobalEvents()},set:function(){var e="";if(!this._unset)e=this.formatDate(this._date);if(!this.isInput){if(this.component){var t=this.$element.find("input");t.val(e);this._resetMaskPos(t)}this.$element.data("date",e)}else{this.$element.val(e);this._resetMaskPos(this.$element)}if(!this.pickTime)this.hide()},setValue:function(e){if(!e){this._unset=true}else{this._unset=false}if(typeof e==="string"){this._date=this.parseDate(e)}else if(e){this._date=new Date(e)}this.set();this.viewDate=d(this._date.getUTCFullYear(),this._date.getUTCMonth(),1,0,0,0,0);this.fillDate();this.fillTime()},getDate:function(){if(this._unset)return null;return new Date(this._date.valueOf())},setDate:function(e){if(!e)this.setValue(null);else this.setValue(e.valueOf())},setStartDate:function(e){if(e instanceof Date){this.startDate=e}else if(typeof e==="string"){this.startDate=new d(e);if(!this.startDate.getUTCFullYear()){this.startDate=-Infinity}}else{this.startDate=-Infinity}if(this.viewDate){this.update()}},setEndDate:function(e){if(e instanceof Date){this.endDate=e}else if(typeof e==="string"){this.endDate=new d(e);if(!this.endDate.getUTCFullYear()){this.endDate=Infinity}}else{this.endDate=Infinity}if(this.viewDate){this.update()}},getLocalDate:function(){if(this._unset)return null;var e=this._date;return new Date(e.getUTCFullYear(),e.getUTCMonth(),e.getUTCDate(),e.getUTCHours(),e.getUTCMinutes(),e.getUTCSeconds(),e.getUTCMilliseconds())},setLocalDate:function(e){if(!e)this.setValue(null);else this.setValue(Date.UTC(e.getFullYear(),e.getMonth(),e.getDate(),e.getHours(),e.getMinutes(),e.getSeconds(),e.getMilliseconds()))},place:function(){var t="absolute";var n=this.component?this.component.offset():this.$element.offset();this.width=this.component?this.component.outerWidth():this.$element.outerWidth();n.top=n.top+this.height;var r=e(window);if(this.options.width!=undefined){this.widget.width(this.options.width)}if(this.options.orientation=="left"){this.widget.addClass("left-oriented");n.left=n.left-this.widget.width()+20}if(this._isInFixed()){t="fixed";n.top-=r.scrollTop();n.left-=r.scrollLeft()}if(r.width()<n.left+this.widget.outerWidth()){n.right=r.width()-n.left-this.width;n.left="auto";this.widget.addClass("pull-right")}else{n.right="auto";this.widget.removeClass("pull-right")}this.widget.css({position:t,top:n.top,left:n.left,right:n.right})},notifyChange:function(){this.$element.trigger({type:"changeDate",date:this.getDate(),localDate:this.getLocalDate()})},update:function(e){var t=e;if(!t){if(this.isInput){t=this.$element.val()}else{t=this.$element.find("input").val()}if(t){this._date=this.parseDate(t)}if(!this._date){var n=new Date;this._date=d(n.getFullYear(),n.getMonth(),n.getDate(),n.getHours(),n.getMinutes(),n.getSeconds(),n.getMilliseconds())}}this.viewDate=d(this._date.getUTCFullYear(),this._date.getUTCMonth(),1,0,0,0,0);this.fillDate();this.fillTime()},fillDow:function(){var t=this.weekStart;var n=e("<tr>");while(t<this.weekStart+7){n.append('<th class="dow">'+s[this.language].daysMin[t++%7]+"</th>")}this.widget.find(".datepicker-days thead").append(n)},fillMonths:function(){var e="";var t=0;while(t<12){e+='<span class="month">'+s[this.language].monthsShort[t++]+"</span>"}this.widget.find(".datepicker-months td").append(e)},fillDate:function(){var t=this.viewDate.getUTCFullYear();var n=this.viewDate.getUTCMonth();var r=d(this._date.getUTCFullYear(),this._date.getUTCMonth(),this._date.getUTCDate(),0,0,0,0);var i=typeof this.startDate==="object"?this.startDate.getUTCFullYear():-Infinity;var o=typeof this.startDate==="object"?this.startDate.getUTCMonth():-1;var u=typeof this.endDate==="object"?this.endDate.getUTCFullYear():Infinity;var a=typeof this.endDate==="object"?this.endDate.getUTCMonth():12;this.widget.find(".datepicker-days").find(".disabled").removeClass("disabled");this.widget.find(".datepicker-months").find(".disabled").removeClass("disabled");this.widget.find(".datepicker-years").find(".disabled").removeClass("disabled");this.widget.find(".datepicker-days th:eq(1)").text(s[this.language].months[n]+" "+t);var f=d(t,n-1,28,0,0,0,0);var l=v.getDaysInMonth(f.getUTCFullYear(),f.getUTCMonth());f.setUTCDate(l);f.setUTCDate(l-(f.getUTCDay()-this.weekStart+7)%7);if(t==i&&n<=o||t<i){this.widget.find(".datepicker-days th:eq(0)").addClass("disabled")}if(t==u&&n>=a||t>u){this.widget.find(".datepicker-days th:eq(2)").addClass("disabled")}var c=new Date(f.valueOf());c.setUTCDate(c.getUTCDate()+42);c=c.valueOf();var h=[];var p;var m;while(f.valueOf()<c){if(f.getUTCDay()===this.weekStart){p=e("<tr>");h.push(p)}m="";if(f.getUTCFullYear()<t||f.getUTCFullYear()==t&&f.getUTCMonth()<n){m+=" old"}else if(f.getUTCFullYear()>t||f.getUTCFullYear()==t&&f.getUTCMonth()>n){m+=" new"}if(f.valueOf()===r.valueOf()){m+=" active"}if(f.valueOf()+864e5<=this.startDate){m+=" disabled"}if(f.valueOf()>this.endDate){m+=" disabled"}p.append('<td class="day'+m+'">'+f.getUTCDate()+"</td>");f.setUTCDate(f.getUTCDate()+1)}this.widget.find(".datepicker-days tbody").empty().append(h);var g=this._date.getUTCFullYear();var y=this.widget.find(".datepicker-months").find("th:eq(1)").text(t).end().find("span").removeClass("active");if(g===t){y.eq(this._date.getUTCMonth()).addClass("active")}if(g-1<i){this.widget.find(".datepicker-months th:eq(0)").addClass("disabled")}if(g+1>u){this.widget.find(".datepicker-months th:eq(2)").addClass("disabled")}for(var b=0;b<12;b++){if(t==i&&o>b||t<i){e(y[b]).addClass("disabled")}else if(t==u&&a<b||t>u){e(y[b]).addClass("disabled")}}h="";t=parseInt(t/10,10)*10;var w=this.widget.find(".datepicker-years").find("th:eq(1)").text(t+"-"+(t+9)).end().find("td");this.widget.find(".datepicker-years").find("th").removeClass("disabled");if(i>t){this.widget.find(".datepicker-years").find("th:eq(0)").addClass("disabled")}if(u<t+9){this.widget.find(".datepicker-years").find("th:eq(2)").addClass("disabled")}t-=1;for(var b=-1;b<11;b++){h+='<span class="year'+(b===-1||b===10?" old":"")+(g===t?" active":"")+(t<i||t>u?" disabled":"")+'">'+t+"</span>";t+=1}w.html(h)},fillHours:function(){var e=this.widget.find(".timepicker .timepicker-hours table");e.parent().hide();var t="";if(this.options.pick12HourFormat){var n=1;for(var r=0;r<3;r+=1){t+="<tr>";for(var i=0;i<4;i+=1){var s=n.toString();t+='<td class="hour">'+h(s,2,"0")+"</td>";n++}t+="</tr>"}}else{var n=0;for(var r=0;r<6;r+=1){t+="<tr>";for(var i=0;i<4;i+=1){var s=n.toString();t+='<td class="hour">'+h(s,2,"0")+"</td>";n++}t+="</tr>"}}e.html(t)},fillMinutes:function(){var e=this.widget.find(".timepicker .timepicker-minutes table");e.parent().hide();var t="";var n=0;for(var r=0;r<5;r++){t+="<tr>";for(var i=0;i<4;i+=1){var s=n.toString();t+='<td class="minute">'+h(s,2,"0")+"</td>";n+=3}t+="</tr>"}e.html(t)},fillSeconds:function(){var e=this.widget.find(".timepicker .timepicker-seconds table");e.parent().hide();var t="";var n=0;for(var r=0;r<5;r++){t+="<tr>";for(var i=0;i<4;i+=1){var s=n.toString();t+='<td class="second">'+h(s,2,"0")+"</td>";n+=3}t+="</tr>"}e.html(t)},fillTime:function(){if(!this._date)return;var e=this.widget.find(".timepicker span[data-time-component]");var t=e.closest("table");var n=this.options.pick12HourFormat;var r=this._date.getUTCHours();var i="AM";if(n){if(r>=12)i="PM";if(r===0)r=12;else if(r!=12)r=r%12;this.widget.find(".timepicker [data-action=togglePeriod]").text(i)}r=h(r.toString(),2,"0");var s=h(this._date.getUTCMinutes().toString(),2,"0");var o=h(this._date.getUTCSeconds().toString(),2,"0");e.filter("[data-time-component=hours]").text(r);e.filter("[data-time-component=minutes]").text(s);e.filter("[data-time-component=seconds]").text(o)},click:function(t){t.stopPropagation();t.preventDefault();this._unset=false;var n=e(t.target).closest("span, td, th");if(n.length===1){if(!n.is(".disabled")){switch(n[0].nodeName.toLowerCase()){case"th":switch(n[0].className){case"switch":this.showMode(1);break;case"prev":case"next":var r=this.viewDate;var i=v.modes[this.viewMode].navFnc;var s=v.modes[this.viewMode].navStep;if(n[0].className==="prev")s=s*-1;r["set"+i](r["get"+i]()+s);this.fillDate();this.set();break}break;case"span":if(n.is(".month")){var o=n.parent().find("span").index(n);this.viewDate.setUTCMonth(o)}else{var u=parseInt(n.text(),10)||0;this.viewDate.setUTCFullYear(u)}if(this.viewMode!==0){this._date=d(this.viewDate.getUTCFullYear(),this.viewDate.getUTCMonth(),this.viewDate.getUTCDate(),this._date.getUTCHours(),this._date.getUTCMinutes(),this._date.getUTCSeconds(),this._date.getUTCMilliseconds());this.notifyChange()}this.showMode(-1);this.fillDate();this.set();break;case"td":if(n.is(".day")){var a=parseInt(n.text(),10)||1;var o=this.viewDate.getUTCMonth();var u=this.viewDate.getUTCFullYear();if(n.is(".old")){if(o===0){o=11;u-=1}else{o-=1}}else if(n.is(".new")){if(o==11){o=0;u+=1}else{o+=1}}this._date=d(u,o,a,this._date.getUTCHours(),this._date.getUTCMinutes(),this._date.getUTCSeconds(),this._date.getUTCMilliseconds());this.viewDate=d(u,o,Math.min(28,a),0,0,0,0);this.fillDate();this.set();this.notifyChange()}break}}}},actions:{incrementHours:function(e){this._date.setUTCHours(this._date.getUTCHours()+1)},incrementMinutes:function(e){this._date.setUTCMinutes(this._date.getUTCMinutes()+1)},incrementSeconds:function(e){this._date.setUTCSeconds(this._date.getUTCSeconds()+1)},decrementHours:function(e){this._date.setUTCHours(this._date.getUTCHours()-1)},decrementMinutes:function(e){this._date.setUTCMinutes(this._date.getUTCMinutes()-1)},decrementSeconds:function(e){this._date.setUTCSeconds(this._date.getUTCSeconds()-1)},togglePeriod:function(e){var t=this._date.getUTCHours();if(t>=12)t-=12;else t+=12;this._date.setUTCHours(t)},showPicker:function(){this.widget.find(".timepicker > div:not(.timepicker-picker)").hide();this.widget.find(".timepicker .timepicker-picker").show()},showHours:function(){this.widget.find(".timepicker .timepicker-picker").hide();this.widget.find(".timepicker .timepicker-hours").show()},showMinutes:function(){this.widget.find(".timepicker .timepicker-picker").hide();this.widget.find(".timepicker .timepicker-minutes").show()},showSeconds:function(){this.widget.find(".timepicker .timepicker-picker").hide();this.widget.find(".timepicker .timepicker-seconds").show()},selectHour:function(t){var n=e(t.target);var r=parseInt(n.text(),10);if(this.options.pick12HourFormat){var i=this._date.getUTCHours();if(i>=12){if(r!=12)r=(r+12)%24}else{if(r===12)r=0;else r=r%12}}this._date.setUTCHours(r);this.actions.showPicker.call(this)},selectMinute:function(t){var n=e(t.target);var r=parseInt(n.text(),10);this._date.setUTCMinutes(r);this.actions.showPicker.call(this)},selectSecond:function(t){var n=e(t.target);var r=parseInt(n.text(),10);this._date.setUTCSeconds(r);this.actions.showPicker.call(this)}},doAction:function(t){t.stopPropagation();t.preventDefault();if(!this._date)this._date=d(1970,0,0,0,0,0,0);var n=e(t.currentTarget).data("action");var r=this.actions[n].apply(this,arguments);this.set();this.fillTime();this.notifyChange();return r},stopEvent:function(e){e.stopPropagation();e.preventDefault()},keydown:function(t){var n=this,r=t.which,i=e(t.target);if(r==8||r==46){setTimeout(function(){n._resetMaskPos(i)})}},keypress:function(t){var n=t.which;if(n==8||n==46){return}var r=e(t.target);var i=String.fromCharCode(n);var s=r.val()||"";s+=i;var o=this._mask[this._maskPos];if(!o){return false}if(o.end!=s.length){return}if(!o.pattern.test(s.slice(o.start))){s=s.slice(0,s.length-1);while((o=this._mask[this._maskPos])&&o.character){s+=o.character;this._maskPos++}s+=i;if(o.end!=s.length){r.val(s);return false}else{if(!o.pattern.test(s.slice(o.start))){r.val(s.slice(0,o.start));return false}else{r.val(s);this._maskPos++;return false}}}else{this._maskPos++}},change:function(t){var n=e(t.target);var r=n.val();if(this._formatPattern.test(r)){this.update();this.setValue(this._date.getTime());this.notifyChange();this.set()}else if(r&&r.trim()){this.setValue(this._date.getTime());if(this._date)this.set();else n.val("")}else{if(this._date){this.setValue(null);this.notifyChange();this._unset=true}}this._resetMaskPos(n)},showMode:function(e){if(e){this.viewMode=Math.max(this.minViewMode,Math.min(2,this.viewMode+e))}this.widget.find(".datepicker > div").hide().filter(".datepicker-"+v.modes[this.viewMode].clsName).show()},destroy:function(){this._detachDatePickerEvents();this._detachDatePickerGlobalEvents();this.widget.remove();this.$element.removeData("datetimepicker");this.component.removeData("datetimepicker")},formatDate:function(e){return this.format.replace(l,function(t){var n,r,i,s=t.length;if(t==="ms")s=1;r=o[t].property;if(r==="Hours12"){i=e.getUTCHours();if(i===0)i=12;else if(i!==12)i=i%12}else if(r==="Period12"){if(e.getUTCHours()>=12)return"PM";else return"AM"}else{n="get"+r;i=e[n]()}if(n==="getUTCMonth")i=i+1;if(n==="getUTCYear")i=i+1900-2e3;return h(i.toString(),s,"0")})},parseDate:function(e){var t,n,r,i,s,o={};if(!(t=this._formatPattern.exec(e)))return null;for(n=1;n<t.length;n++){r=this._propertiesByIndex[n];if(!r)continue;s=t[n];if(/^\d+$/.test(s))s=parseInt(s,10);o[r]=s}return this._finishParsingDate(o)},_resetMaskPos:function(e){var t=e.val();for(var n=0;n<this._mask.length;n++){if(this._mask[n].end>t.length){this._maskPos=n;break}else if(this._mask[n].end===t.length){this._maskPos=n+1;break}}},_finishParsingDate:function(e){var t,n,r,i,s,o,u;t=e.UTCFullYear;if(e.UTCYear)t=2e3+e.UTCYear;if(!t)t=1970;if(e.UTCMonth)n=e.UTCMonth-1;else n=0;r=e.UTCDate||1;i=e.UTCHours||0;s=e.UTCMinutes||0;o=e.UTCSeconds||0;u=e.UTCMilliseconds||0;if(e.Hours12){i=e.Hours12}if(e.Period12){if(/pm/i.test(e.Period12)){if(i!=12)i=(i+12)%24}else{i=i%12}}return d(t,n,r,i,s,o,u)},_compileFormat:function(){var e,t,n=[],r=[],i=this.format,s={},u=0,a=0;while(e=f.exec(i)){t=e[0];if(t in o){u++;s[u]=o[t].property;n.push("\\s*"+o[t].getPattern(this)+"\\s*");r.push({pattern:new RegExp(o[t].getPattern(this)),property:o[t].property,start:a,end:a+=t.length})}else{n.push(c(t));r.push({pattern:new RegExp(c(t)),character:t,start:a,end:++a})}i=i.slice(t.length)}this._mask=r;this._maskPos=0;this._formatPattern=new RegExp("^\\s*"+n.join("")+"\\s*$");this._propertiesByIndex=s},_attachDatePickerEvents:function(){var t=this;this.widget.on("click",".datepicker *",e.proxy(this.click,this));this.widget.on("click","[data-action]",e.proxy(this.doAction,this));this.widget.on("mousedown",e.proxy(this.stopEvent,this));if(this.pickDate&&this.pickTime){this.widget.on("click.togglePicker",".accordion-toggle",function(n){n.stopPropagation();var r=e(this);var i=r.closest("ul");var s=i.find(".in");var o=i.find(".collapse:not(.in)");if(s&&s.length){var u=s.data("collapse");if(u&&u.transitioning)return;s.collapse("hide");o.collapse("show");r.find("span").toggleClass(t.timeIcon+" "+t.dateIcon);t.$element.find(".input-group-addon span").toggleClass(t.timeIcon+" "+t.dateIcon)}})}if(this.isInput){this.$element.on({focus:e.proxy(this.show,this),change:e.proxy(this.change,this)});if(this.options.maskInput){this.$element.on({keydown:e.proxy(this.keydown,this),keypress:e.proxy(this.keypress,this)})}}else{this.$element.on({change:e.proxy(this.change,this)},"input");if(this.options.maskInput){this.$element.on({keydown:e.proxy(this.keydown,this),keypress:e.proxy(this.keypress,this)},"input")}if(this.component){this.component.on("click",e.proxy(this.show,this))}else{this.$element.on("click",e.proxy(this.show,this))}}},_attachDatePickerGlobalEvents:function(){e(window).on("resize.datetimepicker"+this.id,e.proxy(this.place,this));if(!this.isInput){e(document).on("mousedown.datetimepicker"+this.id,e.proxy(this.hide,this))}},_detachDatePickerEvents:function(){this.widget.off("click",".datepicker *",this.click);this.widget.off("click","[data-action]");this.widget.off("mousedown",this.stopEvent);if(this.pickDate&&this.pickTime){this.widget.off("click.togglePicker")}if(this.isInput){this.$element.off({focus:this.show,change:this.change});if(this.options.maskInput){this.$element.off({keydown:this.keydown,keypress:this.keypress})}}else{this.$element.off({change:this.change},"input");if(this.options.maskInput){this.$element.off({keydown:this.keydown,keypress:this.keypress},"input")}if(this.component){this.component.off("click",this.show)}else{this.$element.off("click",this.show)}}},_detachDatePickerGlobalEvents:function(){e(window).off("resize.datetimepicker"+this.id);if(!this.isInput){e(document).off("mousedown.datetimepicker"+this.id)}},_isInFixed:function(){if(this.$element){var t=this.$element.parents();var n=false;for(var r=0;r<t.length;r++){if(e(t[r]).css("position")=="fixed"){n=true;break}}return n}else{return false}}};e.fn.datetimepicker=function(t,r){return this.each(function(){var i=e(this),s=i.data("datetimepicker"),o=typeof t==="object"&&t;if(!s){i.data("datetimepicker",s=new n(this,e.extend({},e.fn.datetimepicker.defaults,o)))}if(typeof t==="string")s[t](r)})};e.fn.datetimepicker.defaults={maskInput:false,pickDate:true,pickTime:true,pick12HourFormat:false,pickSeconds:true,startDate:-Infinity,endDate:Infinity,collapse:true};e.fn.datetimepicker.Constructor=n;var i=0;var s=e.fn.datetimepicker.dates={en:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa","Su"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]}};var o={dd:{property:"UTCDate",getPattern:function(){return"(0?[1-9]|[1-2][0-9]|3[0-1])\\b"}},MM:{property:"UTCMonth",getPattern:function(){return"(0?[1-9]|1[0-2])\\b"}},yy:{property:"UTCYear",getPattern:function(){return"(\\d{2})\\b"}},yyyy:{property:"UTCFullYear",getPattern:function(){return"(\\d{4})\\b"}},hh:{property:"UTCHours",getPattern:function(){return"(0?[0-9]|1[0-9]|2[0-3])\\b"}},mm:{property:"UTCMinutes",getPattern:function(){return"(0?[0-9]|[1-5][0-9])\\b"}},ss:{property:"UTCSeconds",getPattern:function(){return"(0?[0-9]|[1-5][0-9])\\b"}},ms:{property:"UTCMilliseconds",getPattern:function(){return"([0-9]{1,3})\\b"}},HH:{property:"Hours12",getPattern:function(){return"(0?[1-9]|1[0-2])\\b"}},PP:{property:"Period12",getPattern:function(){return"(AM|PM|am|pm|Am|aM|Pm|pM)\\b"}}};var u=[];for(var a in o)u.push(a);u[u.length-1]+="\\b";u.push(".");var f=new RegExp(u.join("\\b|"));u.pop();var l=new RegExp(u.join("\\b|"),"g");var v={modes:[{clsName:"days",navFnc:"UTCMonth",navStep:1},{clsName:"months",navFnc:"UTCFullYear",navStep:1},{clsName:"years",navFnc:"UTCFullYear",navStep:10}],isLeapYear:function(e){return e%4===0&&e%100!==0||e%400===0},getDaysInMonth:function(e,t){return[31,v.isLeapYear(e)?29:28,31,30,31,30,31,31,30,31,30,31][t]},headTemplate:"<thead>"+"<tr>"+'<th class="prev">‹</th>'+'<th colspan="5" class="switch"></th>'+'<th class="next">›</th>'+"</tr>"+"</thead>",contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>'};v.template='<div class="datepicker-days">'+'<table class="table-condensed">'+v.headTemplate+"<tbody></tbody>"+"</table>"+"</div>"+'<div class="datepicker-months">'+'<table class="table-condensed">'+v.headTemplate+v.contTemplate+"</table>"+"</div>"+'<div class="datepicker-years">'+'<table class="table-condensed">'+v.headTemplate+v.contTemplate+"</table>"+"</div>";var m={hourTemplate:'<span data-action="showHours" data-time-component="hours" class="timepicker-hour"></span>',minuteTemplate:'<span data-action="showMinutes" data-time-component="minutes" class="timepicker-minute"></span>',secondTemplate:'<span data-action="showSeconds" data-time-component="seconds" class="timepicker-second"></span>'};m.getTemplate=function(e,t){return'<div class="timepicker-picker">'+'<table class="table-condensed"'+(e?' data-hour-format="12"':"")+">"+"<tr>"+'<td><a href="#" class="btn" data-action="incrementHours"><span class="glyphicon glyphicon-chevron-up"></span></a></td>'+'<td class="separator"></td>'+'<td><a href="#" class="btn" data-action="incrementMinutes"><span class="glyphicon glyphicon-chevron-up"></span></a></td>'+(t?'<td class="separator"></td>'+'<td><a href="#" class="btn" data-action="incrementSeconds"><span class="glyphicon glyphicon-chevron-up"></span></a></td>':"")+(e?'<td class="separator"></td>':"")+"</tr>"+"<tr>"+"<td>"+m.hourTemplate+"</td> "+'<td class="separator">:</td>'+"<td>"+m.minuteTemplate+"</td> "+(t?'<td class="separator">:</td>'+"<td>"+m.secondTemplate+"</td>":"")+(e?'<td class="separator"></td>'+"<td>"+'<button type="button" class="btn btn-primary" data-action="togglePeriod"></button>'+"</td>":"")+"</tr>"+"<tr>"+'<td><a href="#" class="btn" data-action="decrementHours"><span class="glyphicon glyphicon-chevron-down"></span></a></td>'+'<td class="separator"></td>'+'<td><a href="#" class="btn" data-action="decrementMinutes"><span class="glyphicon glyphicon-chevron-down"></span></a></td>'+(t?'<td class="separator"></td>'+'<td><a href="#" class="btn" data-action="decrementSeconds"><span class="glyphicon glyphicon-chevron-down"></span></a></td>':"")+(e?'<td class="separator"></td>':"")+"</tr>"+"</table>"+"</div>"+'<div class="timepicker-hours" data-action="selectHour">'+'<table class="table-condensed">'+"</table>"+"</div>"+'<div class="timepicker-minutes" data-action="selectMinute">'+'<table class="table-condensed">'+"</table>"+"</div>"+(t?'<div class="timepicker-seconds" data-action="selectSecond">'+'<table class="table-condensed">'+"</table>"+"</div>":"")}})(window.jQuery)  
  $('#datetimepicker').datetimepicker({
    format: 'MM/dd/yyyy hh:mm:ss'
  });
  

$('#datetimepicker1').datetimepicker(); 
$('#datetimepicker2').datetimepicker();                                                                                                                                                                                                                                                                                                                                                                                                   
  

</script>
  