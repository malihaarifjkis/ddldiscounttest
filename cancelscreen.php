<?php 
session_start();
require_once "connection.php";
if($_SESSION["username"]==true){

  $name=$_SESSION["username"];

 

$date = date('yy-m-d');
$time = date('h:i:s');
 
  


echo '

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="css/select2.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
   <script src="js/select2.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>';

echo '
<body>

<div class="header">
  <h2>Discount Management System
  <span><a href="user/logout.php"><i class="fa fa-sign-out" style="font-size:24px;color:white;Float:right;"></i>
  </a><i style="font-size:24px;color:white;Float:right;margin-right:30px;">'.$name.'</i>
 
  </span>
  </h2>
</div> ';

echo '<div class="container-fluid">
<form class="form-inline" action="/action_page.php"> 
  <br/>


  <div class="row">


   <input type="hidden" id="code" value='.$_GET['id'].'>
    <br/>
    <label for="codes" style="margin-left:15px;">Reason:</label>
    <textarea style="margin-left:90px;" class="form-control" id="reason"  name="reason" ></textarea>
    
     <br/>
    <br/>
     <button type="button" style="margin-left:150px;" class="btn btn-default"id="savelog" >Save</button>  
    
    </div>
    </form>
    </div>
    </body>
    </html>';
    
    echo'
    <script>
     $("#savelog").click(function(e){
      e.preventDefault();
      
       var id=document.getElementById("code").value;
       var reason=document.getElementById("reason").value;
       
        $.ajax({

                    url:"update/updatestatusreason.php",
                    method:"POST",
                    data:{code:id,reason:reason},
                    success:function(){
                      alert("Record Inserted");
                      
                        var reason=document.getElementById("reason").value="";
                       



            }
        });
         
         
         
         
     })
    </script>';
}
else
{
  header('Location:sigin.php');
}
?>