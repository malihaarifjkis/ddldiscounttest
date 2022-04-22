<?php
$serverName = "WIN-4K804V6ADVQ"; //serverName\instanceName



// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"DDLdisocunt","UID"=>"","PWD"=>"");
//$connectionInfo = array( "Database"=>"DDLdisocunt","UID"=>"sa","PWD"=>"$0ftware");
$con = sqlsrv_connect( $serverName, $connectionInfo);

if( $con ) {
     //echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

 /* $sql = "select * from item"; 
  $stmt = sqlsrv_query( $conn, $sql );
  
  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
		echo $row['Description_1']."<br />";
  }
 */
?>