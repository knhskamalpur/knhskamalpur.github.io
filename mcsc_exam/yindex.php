<?php
include 'func.php';
if(isset($_POST['reg'])){
	$dir=scandir('./candidates');
	$find=false;
	foreach($dir as $k){
		if(ext($k)=='profile'){
			$metadata=json_decode(file_get_contents('./candidates/'.$k),true);
			if($metadata['registration-no']==$_POST['reg'] and $metadata['dob']==$_POST['dob']){
				$find=true;
				break;
			}
		}
	}
	if($find==true){
		$jdb=json_encode($metadata);
		$jdb=str_replace('null','"NULL"',$jdb);
		$jdb=str_replace('\r\n','<br>',$jdb);
		$jdb=str_replace('\\"','\\\\"',$jdb);
		echo $jdb;
	}
	else{
		echo 'FAIL';
	}
}
else{
$title='Download Admit';
include 'header.php';
echo '
  <body>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="slate">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Admit</h5>
			<button type="button" class="close d-print-none" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="row my-3">
			  <div class="col-4 h6">Candidate Name: </div>
			  <div class="col-4 ml-auto" id="cname"></div>
			</div>
			<div class="row my-3">
			  <div class="col-4 h6">C/O: </div>
			  <div class="col-4 ml-auto" id="fname"></div>
			</div>
			<div class="row my-3">
			  <div class="col-4 h6">Date of Birth: </div>
			  <div class="col-4 ml-auto" id="ddob"></div>
			</div>
			<div class="row my-3">
			  <div class="col-4 h6">Registration No: </div>
			  <div class="col-4 ml-auto" id="rno"></div>
			</div>
			<div class="row my-3">
			  <div class="col-4 h6">Roll No: </div>
			  <div class="col-4 ml-auto" id="roll"></div>
			</div>
			<div class="row my-3">
			  <div class="col-4 h6">Date-Time: </div>
			  <div class="col-4 ml-auto" id="ddt"></div>
			</div>
		  </div>
		  <div class="modal-footer d-print-none">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
		  </div>
		</div>
	  </div>
	</div>
	
	
	
  
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				
			</div>
			<div class="col-xs-10 col-sm-8 col-md-4 red_boxx">
				<div class="card mt-5 d-print-none">
					<div class="card-header">
						<h4 class="card-title">Admit Download</h4>
					</div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
						  <div class="form-group">
							<label for="reg">Registration No: </label>
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon1">Registration No: </span>
							  <input type="text" name="registration" class="form-control" id="reg" aria-describedby="emailHelp" placeholder="Enter Registration No">
							</div>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Date of Birth:</label>
							<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1">Date of Birth:</span>
							<input id="dob" type="date" name="dob" class="form-control" value="'.date('Y-m-d').'" id="exampleInputPassword1" placeholder="Enter Date of Birth">
							</div>
						  </div>
						  <!--<div class="form-check">
							<label class="form-check-label">
							  <input type="checkbox" class="form-check-input">
							  Check me out
							</label>
						  </div>-->
						  <button type="button" class="btn btn-primary w-100" id="dwn">Download</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col">
				
			</div>
		</div>
		<div class="row d-none justify-content-md-center mt-3" id="load">
			<div class="col-auto h2">Loading...</div>
		</div>
	</div>
	
	<nav class="navbar fixed-bottom navbar-light bg-light">
		<div class="navbar-brand mx-auto h5">Developed By <a href="http://sorisoft.ml/">SoRi Soft</a></div>
	</nav>
	';
include 'footer.php';	
echo '
<script>
$(document).ready(function(){

	$("#dwn").on("click",function(){
		reg = $("#reg").val();
		dob = $("#dob").val();
		$.ajax({
			type: "POST",
			url: "'.basename(__FILE__).'",
			dataType: "text",
			data: "reg=" + reg + "&dob=" + dob,
			beforeSend: function(x){
				$("#load").toggleClass("d-none");
			},
			success: function(msg){
				$("#load").toggleClass("d-none");
				if(msg=="FAIL"){
					alert("Invalid Information.");
				}
				else{
					data=JSON.parse(msg);
					$("#cname").html(data["candidate-name"]);
					$("#fname").html(data["c-o"]);
					$("#ddob").html(data["dob"]);
					$("#rno").html(data["registration-no"]);
					$("#roll").html(data["roll-no"]);
					$("#ddt").html(data["exam-date"]+" - "+data["batch"]);
					$("#slate").modal("show");
					//console.log(data);
				}
			}
		}).fail(function() {
		});
		
	});
});
</script>';
}
?>
