<?php
session_start();
include "connection.php";
include "mssqlconnection.php";
error_reporting(0);
if($_SESSION["username"]==true){
$name=$_SESSION["username"];

$pnameid=$_POST['pnameid'];
//echo $pnameid;

//$queryproprice="select i.Code, p.ProdCode,p.Price_Excl_Vat as 'price' from item i inner join  price p on p.ProdCode=i.Code where i.code='$pnameid'";
$queryproprice="select TOP 1 f1.[fExclPrice]  as 'price'  from  CAL.dbo.StkItem f0 , CAL.[dbo].[_etblPriceListPrices] f1 where  f1.iStockID = f0.StockLink 
  and f0.ulIIDEPT = 'USINE' and f0.[cSimpleCode] ='$pnameid'";


$stmt = sqlsrv_query($con,$queryproprice );

	while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
	
	 $proprice=$row['price'];
	}
	$proprice;
	if($proprice==""){
		echo "<script>
            alert('price missing please select another one item');
			document.getElementById('prices').value = '0';
			 
			  </script>";
			 
	}
	
	else {
	echo "<script>
             document.getElementById('prices').value = '$proprice';
			 
			  </script>";
	}
			 
}
?>