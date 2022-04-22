<?php
session_start();
if($_SESSION["username"]==true){
$name=$_SESSION["username"];
echo '<html class=\"no-js\" lang=\"\">
<title>DDLDMS</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
<!--===============================================================================================-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet"  type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="js/select2.min.js"></script>
  <link href="css/select2.min.css" rel="stylesheet" />
  
  <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

</head>
 
  ';
echo '
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <img class="navbar-brand" src="images/ddllogo.png" width="10%">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="searchscreen.php" style="color:white;font-size:24px;font-weight:bold">Search <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="newscreen.php" style="color:white;font-size:24px;font-weight:bold">New</a>
      </li>
       <h1 style="color:white;text-align:center;margin-left:180px;font-size:34px">Discount Management System</h1>
    </ul>


    <form class="form-inline my-2 my-lg-0">
      <span><b><i style="font-size:20px;color:white;Float:right;margin-right:20px;font-family:OpenSans-Regular;">'.$_SESSION["username"].'</i></b>
                         </span></p>
      <span><i class="fa fa-user" style="font-size:24px;color:white;Float:right;margin-right:20px;"></i>
                         </span>
      <span><a href="user/signout.php"><i class="fa fa-sign-out" style="font-size:24px;color:white;Float:right;"></i></a></span>
                          
    </form>
  </div>
</nav>';
}
else{
	header('Location:index.php');
}