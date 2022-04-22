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
          $user_id=$row2['id'];
		 
		
		
		$id=$_GET['id'];
		$queryselect = "select id as 'disccode',focheaderid as 'focid', datefrom as  'df', dateto as 'dt', 
		description as 'dsecp' , discountype as 'type' from DiscountFocHeader where id='$id'";
		//echo $queryselect ;
    $stmt = sqlsrv_query($con,$queryselect );
	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $disccode=$row['disccode'];
			$focid=$row['focid'];
			$df=$row['df'];
			$timestamp=$df;
			$datefrom=date_format($timestamp,'Y-m-d');
			$dt=$row['dt'];
			$timestamp=$dt;
			$dateto=date_format($timestamp,'Y-m-d');
			$dsecp=$row['dsecp'];
			$type=$row['type'];
		

	}
	
$date = date('Y-m-d');


    echo '<div class="container-fluid" style="position:fixed; background-color: white;border-bottom: 4px solid black;">
  <h3 style="text-align:center;"><u>Discount Information</u></h3>
  <br>
  <form class="form-inline" > 
  <div class="row" >


    <label for="codes" style="margin-left:15px;">Code</label>
	<input type="hidden" style="margin-left:35px;" class="form-control" value='.$focid.' id="coderand"  name="coderand" readonly>
    <input type="hidden" style="margin-left:35px;" class="form-control" value='.$user_id.' id="userid"  name="userid">
	
    <input type="text" style="margin-left:35px;" class="form-control" id="code"  name="code" value='.$disccode.' readonly>
    <label for="dates" style="margin-left:20px;">Date From</label> 
    <input type="date" class="form-control" style="margin-left:15px;" id="datef" placeholder="Enter Date" name="datef" min='.$date.' value='.$datefrom.'>
    <label for="quant" style="margin-left:15px;">Discount Type</label>
    <select style="margin-left:15px;width:100px" class="form-control" id="disctype" name="disctype" onchange="getidcus(this.value)" >
   <option  value='.$type.' >'.$type.'</option>
   <option  disabled="disabled" value="0" >select</option>
  <option  value="1" selected>Customer Discount</option>
    </select>
    <label for="quant" style="margin-left:150px;"></label>

     <button type="button" class="btn btn-default" onclick="newscreen()">New</button>
    <label for="quant" style="margin-left:15px;"></label> 
    <button type="button" class="btn btn-default" id="saveheader">Update</button>

    </div>
    <br/>
    <br/>
    <br/>

    <div class="row">
    

    <label for="desc" style="margin-left:10px;">Description</label> 
    <input type="textarea" class="form-control" id="descr"  name="descr" value='.$dsecp.'>
    <label for="date" style="margin-left:15px;">Date To</label>
    <input type="date" style="margin-left:35px;" class="form-control" id="dateto" placeholder="Enter Date" name="dateto" min='.$date.' value='.$dateto.'>
    <label for="quant" style="margin-left:15px;">Created By</label> 
    <input type="text" style="margin-left:35px;" class="form-control" id="fquant" name="fquant" value='.$name.' readonly>  
     <label for="quant" style="margin-left:50px;"></label>


    <button type="button" class="btn btn-default" onclick="searchcreen()">Search</button>
    <label for="quant" style="margin-left:15px;"></label> 
    <button type="button" class="btn btn-default" onclick="duplicatescreen('.$id.')">Duplicate</button>
	<button type="button" class="btn btn-default" onclick="cancel('.$id.')">Cancel</button>
       
  </div>
    
    </form>
    </div>';
echo ' <hr  style="border: 1.5px solid gray;>';

echo '
<div class="row">
  <div class="column left">
    <h2>Product Combination</h2>
 <br>

 
  <br/>

  
  
  
<div id="results"></div>

   <div class="table-responsive"style="padding-top:30px;">
                    <table class="table table-bordered" >
                          <tr>
						   <th></th>
                              <th>Product</th>
                              <th>ProductCode</th>
                              <th>PriceExclVat</th>
                              <th>Discount(%)</th>
                              <th>DiscountPriceExclVat</th>
                          </tr>';
			  $querypro = " select p.proid as 'id',p.focheaderid , p.procode as 'code' ,p.originalprice as 'price',
			  p.discountprice as 'priceexcl',p.discountper as 'disc', i.Description_1 as 'name' from DiscountFocProduct p inner join item i 
			  on p.procode=i.Code where p.focheaderid='$focid' ORDER BY p.procode DESC";
			  $stmt = sqlsrv_query($con,$querypro );
						  echo '
                          <tbody id="buycontent">';
						  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
	 echo '<tr>
	 <td> <button type="button" onclick=deletepro('.$row["id"].') class="btn btn-danger" style="background-color:red;">x</button></td>
           <td>'.$row['name'].'</td>
            <td>'.$row['code'].'</td>
			 <td>'.$row['price'].'</td>
			  <td>'.$row['disc'].'</td>
			   <td>'.$row['priceexcl'].'</td>
            </tr>';
	
	}
						  echo '
                          </tbody>
                    </table>
              </div>


  </div>
  <div class="column right">
    <h2>Eligible Customers</h2>
   
     
      
      

      <div class="table-responsive"style="padding-top:80px;">
                    <table class="table table-bordered" >
                          <tr>
						  <th></th>
                              <th>Code</th>
                              <th>Name</th>
                          </tr>';
						  $querycusto = " select c.focheaderid , c.cuscode as 'code' , c.cusid as 'id', i.Description as 'name' from 
						  DiscountFocCustomer c inner join customer i on c.cuscode=i.Code where c.focheaderid='$focid' ORDER BY c.cuscode DESC"; 
						  $stmt = sqlsrv_query($con,$querycusto );
						  echo'
                          <tbody id="cuscontent">';
						  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
	 echo '<tr>
	 <td> <button type="button" onclick=deletecus('.$row["id"].') class="btn btn-danger" style="background-color:red;">x</button></td>
           <td>'.$row['code'].'</td>
            <td>'.$row['name'].'</td>
			 
            </tr>';
	
	}
						  echo '
                          </tbody>
                    </table>
              </div>

  </div>
</div>';
}
else
{
include "footer.php";
header('Location:index.php');
}


?>

<script>
$(document).ready(function() {
    
   $("#pname").select2();
   $("#cusname").select2(); 
   

	document.getElementById("addpro").disabled=true;
	
           /* var startDate = document.getElementById("datef").value; 
               var endDate =  document.getElementById("dateto").value;
           if(endDate < startDate){
               alert("DATE TO SHOULD BE GREATER THAN START DATE");
               document.getElementById("dateto").value="";
           }  */ 
//)};
});

$("#dateto").change(function(){
	//alert('chk');
	 var startDate = document.getElementById("datef").value; 
               var endDate =  document.getElementById("dateto").value;
           if(endDate < startDate){
               alert("DATE TO SHOULD BE GREATER THAN START DATE");
               document.getElementById("dateto").value="";
           }   
});

function disablebutton(){
	document.getElementById("addpro").disabled=false;
}


	


$("#saveheader").click(function(e){
	 
        e.preventDefault();
	var code =  document.getElementById("code").value;
	var coderand=document.getElementById("coderand").value;
    var datef=document.getElementById("datef").value;
	var disctype=document.getElementById("disctype").value;
    var descr=document.getElementById("descr").value;
	var dateto=document.getElementById("dateto").value;
    var userid=document.getElementById("userid").value;
	
	/*alert(code);
	alert(coderand);
	alert(datef);
	alert(disctype);
	alert(descr);
	alert(dateto);
	alert(userid); */
	
$.ajax({

                    url:"update/focheaderupdate.php",
                    method:"POST",
                     data:{code:code,coderand:coderand,datef:datef,disctype:disctype,descr:descr,dateto:dateto,userid:userid},
                    success:function(){
                        alert("Record updated Successfully");
					}
						
					});
					
					
	
});

function deletepro(id){
       // alert(id);
		var coderand=document.getElementById("coderand").value;
		//alert(coderand);
        
        $.ajax({

            url:'delete/deletepro.php',
            method:'POST',
            data:{id:id},
            success:function(){
				alert("Record deleted Successfully");
               $("#buycontent").load("get/focproitem.php?code="+coderand); 

            }
        })





    }

function deletecus(id){
        //alert(id);
		var coderand=document.getElementById("coderand").value;
		//alert(coderand);
        
        $.ajax({

            url:'delete/deletecus.php',
            method:'POST',
            data:{id:id},
            success:function(){
				alert("Record deleted Successfully");
                $("#cuscontent").load("get/foccus.php?code="+coderand);

            }
        })





    }

function getpid(){
        var pnameid = $("#pname").val();
		document.getElementById("discper").value="";
		document.getElementById("discprice").value="";
		
		 $.ajax({

                    
                    method:"POST",
                    data:{pnameid:pnameid},
                    url: "getproprice.php",
                    success:function(response){
                     $( "#results" ).empty().append( response );


            }
        });
		
		
}

function getcusid(){
        var cusnameid = $("#cusname").val();
		
		
}
 function Reset() {
        $("#cusname").select2('val','Select');
    }
	function proReset() {
       // $("#pname").select2('val','Select');
		document.getElementById("discper").value="";
		document.getElementById("discprice").value="";
		document.getElementById("prices").value="";
    }
function newscreen(){
	window.open("newscreen.php","_self");
}
function searchcreen(){
	window.open("searchscreen.php","_self");
}
function duplicatescreen(id){
	window.open("duplicatescreen.php?id="+id,"_self");
}
function cancel(id){
	  alert("insert the reason for discount cancellation")
               var win = window.open("cancelscreen.php?id="+id, "_target");
              win.focus()
}
</script>