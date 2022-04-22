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
		 
		$rand=rand();
		
		
		$querycheck = "select max(id) as 'id' from DiscountFocHeader;";
    $stmt = sqlsrv_query($con,$querycheck );
	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $ids=$row['id'];
	}
	 $codeafter=$ids+1;
$date = date('Y-m-d');


    echo '<div class="container-fluid">
  <h3 style="text-align:center;"><u>Discount Information</u></h3>
  <br>
  <form class="form-inline"> 
  <div class="row">


    <label for="codes" style="margin-left:15px;">Code</label>
	<input type="hidden" style="margin-left:35px;" class="form-control" value='.$rand.' id="coderand"  name="coderand" readonly>
    <input type="hidden" style="margin-left:35px;" class="form-control" value='.$user_id.' id="userid"  name="userid">
	
    <input type="text" style="margin-left:35px;" class="form-control" id="code"  name="code" readonly>
    <label for="dates" style="margin-left:20px;">Date From</label> 
    <input type="date" class="form-control" style="margin-left:15px;" id="datef" placeholder="Enter Date" name="datef" min='.$date.'>
    <label for="quant" style="margin-left:15px;">Discount Type</label>
    <select style="margin-left:15px;width:200px" class="form-control" id="disctype" name="disctype" onchange="getidcus(this.value)" >
   <option selected="true" disabled="disabled" value="0" >Select</option>
   <option  value="1" selected>Customer Discount</option>
    </select>
    <label for="quant" style="margin-left:150px;"></label>

    <button type="button" class="btn btn-default" onclick="newscreen()">New</button>
    <label for="quant" style="margin-left:15px;"></label> 
    <button type="button" class="btn btn-default" id="saveheader">Save</button>

    </div>
    <br/>
    <br/>
    <br/>

    <div class="row">
    

    <label for="desc" style="margin-left:10px;">Description</label> 
    <input type="textarea" class="form-control" id="descr"  name="descr">
    <label for="date" style="margin-left:15px;">Date To</label>
    <input type="date" style="margin-left:35px;" class="form-control" id="dateto" placeholder="Enter Date" name="dateto" min='.$date.'>
    <label for="quant" style="margin-left:15px;">Created By</label> 
    <input type="text" style="margin-left:35px;" class="form-control" id="fquant" name="fquant" value='.$name.' readonly>  
     <label for="quant" style="margin-left:50px;"></label>


    <button type="button" class="btn btn-default" onclick="searchcreen()">Search</button>
    <label for="quant" style="margin-left:15px;"></label> 
    <button type="button" class="btn btn-default" id="saveall">Cancel</button>
       
  </div>
    
    </form>
    </div>';
echo ' <hr  style="border: 1.5px solid gray;>';

echo '
<div class="row">
  <div class="column left">
    <h2>Product Combination</h2>
   <div class="row"> 
   <div class="col-1">
    <label for="desc" style="margin-left:10px;">Product</label>
    </div>
     <label for="desc" style="margin-left:10px;"></label>';
     $querycus = "select f0.Description_1 as 'pname' , f0.[cSimpleCode] as 'id' from  CAL.dbo.StkItem f0 where f0.ulIIDEPT = 'USINE'";
    $stmt = sqlsrv_query($con,$querycus );
        
  echo'   <select style="width:20%;margin-left:15px;" class="form-control" id="pname" name="pname" onchange="getpid(this.value)">
          <option selected="true" disabled="disabled" value="0">Select</option>';
		  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            $ids=$row['id'];

       echo' <option class="form-control" value='.$row['id'].'>'.$row['id'].'-'.$row['pname'].'</option>';
       }
      echo '    
          </select> ';
          
          echo '
          
          <label for="desc" style="margin-left:38%;"></label> 
        <label for="desc" style="margin-left:10px;">Price</label> ';
      echo '  <input type="text" style="width:25%;margin-left:10px" class="form-control" id="prices" name="prices" readonly value='.$proprice.'>
          
 </div>
 <br>

  <div class="row"> 
  
    <label style="margin-left:64%"></label>

           
   <label for="desc" style="margin-left:10px;">Disc Price</label>
   <input type="text" style="width:25%;margin-left:10px" class="form-control" id="discprice" name="discprice" onchange="calcdisc(this.value)" onkeyup="calcdisc()" onfocusout="disablebutton()">
   
  </div>
  <br/>

  <div class="row">
 
<label for="desc" style="margin-left:65%;"></label> 
 <label for="desc" style="margin-left:10px;">Disc(%)</label>
   <input type="text" style="width:25%;margin-left:15px" class="form-control" id="discper" name="discper" onchange="calcdiscper(this.value)" onkeyup="calcdiscper()" onfocusout="disablebutton()">
 
</div>
  <div class="row">
   
<label style="margin-left:45%;"></label>
<button type="button" class="btn btn-default" id="addpro"><i class="fa fa-plus" style="color:white;"></i></button>
<label style="margin-left:10px"></label>


  </div>
  
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
                          </tr>
                          <tbody id="buycontent">
                          </tbody>
                    </table>
              </div>


  </div>
  <div class="column right">
    <h2>Eligible Customers</h2>
    <div class="row"> 
   <div class="col-1">
    <label for="desc" style="margin-left:10px;">Customer</label>
    </div>
	<label for="desc" style="margin-left:60px;"></label>';
	$querycust = "SELECT Code as 'id',Description as 'cusname' FROM customer";
    $stmt = sqlsrv_query($con,$querycust );
	echo '
     <select style="width:50%;margin-left:60px;" class="form-control" id="cusname" name="cusname" onchange="getcusid(this.value)">
          <option selected disabled >Select</option>';
		  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
            

       echo' <option class="form-control" value='.$row['id'].'>'.$row['id'].'-'.$row['cusname'].'</option>';
       }
	   echo '
          </select> 
      </div>
     
      <br/>
      <div class="row">
      <label style="margin-left:40%;"></label>
<button type="button" class="btn btn-default" id="addcus"><i class="fa fa-plus" style="color:white;"></i></button>
<label style="margin-left:10px"></label>

      </div>
      <br/>
      <br/>

      <div class="table-responsive"style="padding-top:80px;">
                    <table class="table table-bordered" >
                          <tr>
						  <th></th>
                              <th>Code</th>
                              <th>Name</th>
                          </tr>
                          <tbody id="cuscontent">
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

function calcdisc(){
	var prices = $("#prices").val();
	var discprice = $("#discprice").val();
	var discp = prices - discprice;
	var discpp = discp/prices;
	var discfinal=discpp*100;
	//var disc = (prices - (prices*discper/100));
	$("#discper").val(discfinal.toFixed(2));
}
function calcdiscper(){
	var prices = $("#prices").val();
	var discper= $("#discper").val();
	var disc = (prices - (prices*discper/100));
	$("#discprice").val(disc.toFixed(2));
}

$("#addpro").click(function(e){
      e.preventDefault();
    var pnames=document.getElementById("pname").value;
var code=document.getElementById("coderand").value;
var prices=document.getElementById("prices").value;
var discper=document.getElementById("discper").value;
var discprice=document.getElementById("discprice").value;
//alert(prices);



 if(pnames==0){
      alert("please select  value from dropdown first");

    }
	
	else{
		 $.ajax({

                    url:"insert/discfocproduct.php",
                    method:"POST",
                    data:{pnames:pnames,code:code,discper:discper,prices:prices,discprice:discprice},
                    success:function(){
                     // alert("Record Inserted Successfully");
                       $("#buycontent").load("get/focproitem.php?code="+code);
					   proReset();
					   document.getElementById("addpro").disabled=true;
					  
                       



            }
        });
	} 

});

$("#addcus").click(function(e){
      e.preventDefault();
    var cusnames=document.getElementById("cusname").value;
var code=document.getElementById("coderand").value;

if(cusnames==0){
      alert("please select  value from dropdown first");

    }
	
	else{
		 $.ajax({

                    url:"insert/discfoccus.php",
                    method:"POST",
                    data:{cusnames:cusnames,code:code},
                    success:function(){
                     // alert("Record Inserted Successfully");
                       $("#cuscontent").load("get/foccus.php?code="+code);
					   Reset();
                       



            }
        });
	}

});
$("#saveheader").click(function(e){
	var codeafter = "<?php echo $codeafter; ?>";
	//alert(codeafter);
      var php_var = "DDL_"+codeafter;
        var disccode=$("#code").val(php_var);
        document.getElementById("code").innerHTML = disccode;  
        e.preventDefault();
	var coderand=document.getElementById("coderand").value;
    var datef=document.getElementById("datef").value;
	var disctype=document.getElementById("disctype").value;
    var descr=document.getElementById("descr").value;
	var dateto=document.getElementById("dateto").value;
    var userid=document.getElementById("userid").value;
	/* alert(coderand);
	alert(datef);
	alert(disctype);
	alert(descr);
	alert(dateto);
	alert(userid); */
	
$.ajax({

                    url:"insert/focheader.php",
                    method:"POST",
                     data:{coderand:coderand,datef:datef,disctype:disctype,descr:descr,dateto:dateto,userid:userid},
                    success:function(){
                        alert("Record Inserted Successfully");
					}
						
					});
					 document.getElementById("saveheader").disabled=true;
					
	
});


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
</script>