<?php
    include "header.php";
	include "mssqlconnection.php";
    include "connection.php";
	error_reporting(0);
    if($_SESSION["username"]==true){
		
		$queryheader = "SELECT *  FROM `user` WHERE username=?";
          $stmt = $GLOBALS['conn']->prepare($queryheader);
          $stmt->bind_param("s", $name);
          $stmt->execute();
          $result2 = $stmt->get_result();
          $row2 = $result2->fetch_assoc();
          $name=$row2['username'];
		 

		
		
	echo 
'<div class="container mt-3">
  <h3 style="text-align:center;"><u>Search Screen</u></h3>
   
<hr>
	
';
echo '<div class="table-responsive" style="padding-top:15px;" id="all">
                    <table class="table table-bordered" id="viewtable" >
                    <thead>
                    <tr>
                             
                              <th>Disc Code</th>
                              <th>Date From</th>
                               <th>Date To</th>
                              <th>Created by</th>
                              <th>Disc Description</th>
                             
                             
                          </tr>
                          </thead>';
						   //$old=$_POST['old'];
				    /*$newcode=$_POST['newcode']; 
				    $descr=$_POST['descr'];*/
						   $selectquery = "select id as 'disccode', CAST(datefrom as date)  'df', dateto as 'dt', description as 'dsecp' from DiscountFocHeader";
						  
						  
							  $selectquery .=" ORDER BY [createddate] DESC";
						  $stmt = sqlsrv_query($con,$selectquery );
						  
						  echo '<tbody>';
						  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
							 // print_r($row);
							$disccode=$row['disccode'];
							 $df=$row['df'];
							 $timestamp=$df;
							 $datefrom=date_format($timestamp,'Y-m-d');
							 $dt=$row['dt'];
							 $timestamp=$dt;
							 $dateto=date_format($timestamp,'Y-m-d');
							 $description=$row['description'];
							 echo '<tr>
						  <td><a href="viewscreen.php?id='.$disccode.'">DDL_'.$row['disccode'].'</a></td>
						  <td>'.$datefrom.'</td>
						  <td>'.$dateto.'</td>
						  <td>'.$name.'</td>
						  <td>'.$row['dsecp'].'</td>
						  </tr>';
							 
							 
						}
						  
						

echo '
 </tbody>
                           </table>
                          </div>

</div>';
	}
	else
{
include "footer.php";
header('Location:index.php');
}


?>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>

$(document).ready( function () {
    $('#viewtable').DataTable({
    	dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
});    
</script>