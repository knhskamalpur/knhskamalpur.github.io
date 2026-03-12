<?php
include 'func.php';
if(isset($_POST['roll'])){
	$dir='./candidates';
	$find=false;
	/*foreach($dir as $k){
		if(ext($k)=='profile'){
			$metadata=json_decode(file_get_contents('./candidates/'.$k),true);
			if($metadata['registration-no']==$_POST['roll'] and $metadata['dob']==$_POST['dob']){
				$find=true;
				break;
			}
		}
	}*/
	if(file_exists($dir.'/'.$_POST['roll'].'.submit')){
		$metadata=json_decode(file_get_contents($dir.'/'.$_POST['roll'].'.submit'),true);
		if($metadata['student']['dob']==$_POST['dob']){
			$jdb=json_encode($metadata);
			//$jdb=str_replace('null','"NULL"',$jdb);
			//$jdb=str_replace('\r\n','<br>',$jdb);
			//$jdb=str_replace('\\"','\\\\"',$jdb);
			echo $jdb;
		}
		else{
			echo 'FAIL';
		}
	}
	else{
		echo 'FAIL';
	}
}
else{
$title='Download Report Card';
include 'header.php';
echo '
  <body>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="slate">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Report Card</h5>
			<button type="button" class="close d-print-none" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" id="mbody">
			<div class="row my-1">
			  <div class="col-4 h6">Candidate Name: </div>
			  <div class="col-4 ml-auto" id="cname"></div>
			</div>
			<div class="row my-1">
			  <div class="col-4 h6">C/O: </div>
			  <div class="col-4 ml-auto" id="fname"></div>
			</div>
			<div class="row my-2">
			  <div class="col-4 h6">Date of Birth: </div>
			  <div class="col-4 ml-auto" id="ddob"></div>
			</div>
			<div class="row my-1">
			  <div class="col-4 h6">Registration No: </div>
			  <div class="col-4 ml-auto" id="rno"></div>
			</div>
			<div class="row my-1">
			  <div class="col-4 h6">Roll No: </div>
			  <div class="col-4 ml-auto" id="roll"></div>
			</div>
			<div class="row my-1">
			  <div class="col-4 h6">Date/Time: </div>
			  <div class="col-4 ml-auto" id="ddt"></div>
			</div>
			<div class="row my-3 mx-1 p-1 border">
			  <div class="col"><b>Correct: </b><span id="cans"></span></div>
			  <div class="col"><b>Wrong: </b><span id="wans"></span></div>
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
						<h4 class="card-title">Report Card Download</h4>
					</div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
						  <div class="form-group">
							<label for="roll">Roll No: </label>
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon1">Roll No: </span>
							  <input type="text" name="registration" class="form-control" id="rolll" aria-describedby="emailHelp" placeholder="Enter Roll No">
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
	
	<nav class="navbar fixed-bottom navbar-light bg-light" id="footer">
		<div class="navbar-brand mx-auto h5">Developed By <a href="http://sorisoft.ml/">SoRi Soft</a></div>
	</nav>
	';
include 'footer.php';	
echo '
<script>
$(document).ready(function(){

	$("#dwn").on("click",function(){
		$(".delrow").remove();
		roll = $("#rolll").val();
		dob = $("#dob").val();
		$.ajax({
			type: "POST",
			url: "'.basename(__FILE__).'",
			dataType: "text",
			data: "roll=" + roll + "&dob=" + dob,
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
					document.title="Report Card of " + data["student"]["candidate-name"] + " - " + data["student"]["roll-no"];
					$("#cname").html(data["student"]["candidate-name"]);
					$("#fname").html(data["student"]["c-o"]);
					$("#ddob").html(data["student"]["dob"]);
					$("#rno").html(data["student"]["registration-no"]);
					$("#roll").html(data["student"]["roll-no"]);
					$("#ddt").html(data["student"]["exam-date"] + " - " + data["student"]["batch"]);
					var Q;
					$.getJSON( "qustions/set-1.q", function( QN ) {
						Q=QN;
						console.log(QN);
					
					var xi=0;
					var cans=0;
					var wans=0;
					$.each( data.paper.section, function( k1, v1 ) {
						$.each( v1.qustion, function( k2, v2 ) {
							++xi;
							var holder="<img src=\"holder.png\" style=\"width:20px;height:20px;\"/> ";
							var tick="<img src=\"tick.png\" style=\"width:20px;height:20px;\"/> ";
							var ht="";
								ht+="<div class=\"row my-3 mx-1 p-1 border border-dark delrow\" id=\"row_"+xi+"\">";
								  ht+="<div class=\"col-12\" style=\"overflow-wrap: break-word;\" id=\"q_"+xi+"\"><b>"+xi+". </b></div>";
								  ht+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_a_"+xi+"\"></div>";
								  ht+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_b_"+xi+"\"></div>";
								  ht+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_c_"+xi+"\"></div>";
								  ht+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_d_"+xi+"\"></div>";
								ht+="</div>";
								$("#mbody").append(ht);
								if(v2.q_txt != "")
									$("#q_"+xi).append(v2.q_txt);
								else
									$("#q_"+xi).append("<img src=\"+v2.q_img+\" style=\"width:100%;height:auto;\"/>");
								if(v2.opt_a_txt != "")
									$("#opt_a_"+xi).append("A) "+v2.opt_a_txt);
								else
									$("#opt_a_"+xi).append("A) <img src=\"+v2.opt_a_img+\" style=\"width:100%;height:auto;\"/>");
								if(v2.opt_b_txt != "")
									$("#opt_b_"+xi).append("B) "+v2.opt_b_txt);
								else
									$("#opt_b_"+xi).append("B) <img src=\"+v2.opt_b_img+\" style=\"width:100%;height:auto;\"/>");
								if(v2.opt_c_txt != "")
									$("#opt_c_"+xi).append("C) "+v2.opt_c_txt);
								else
									$("#opt_c_"+xi).append("C) <img src=\"+v2.opt_c_img+\" style=\"width:100%;height:auto;\"/>");
								if(v2.opt_d_txt != "")
									$("#opt_d_"+xi).append("D) "+v2.opt_d_txt);
								else
									$("#opt_d_"+xi).append("D) <img src=\"+v2.opt_d_img+\" style=\"width:100%;height:auto;\"/>");
									
								console.log(Q);
							var R=Q.q[v2.id].rans;
							$("#opt_"+R+"_"+xi).addClass("border border-dark rounded");
							$.each([ "a","b","c","d" ], function( dx, vl ) {
								if(v2.ans==vl)
									$("#opt_"+vl+"_"+xi).prepend(tick);
								else
									$("#opt_"+vl+"_"+xi).prepend(holder);
							});
							
							if( v2.ans!="NULL"){
								if(v2.ans==R)
									cans++;
								else
									wans++;
								$("#cans").html(cans);
								$("#wans").html(wans);
							}
						});
					});
					var copy="<div class=\"row mt-3 mx-1 p-1 border rounded text-center delrow\" id=\"row_x\">";
								  copy+="<div class=\"col-12\" style=\"overflow-wrap: break-word;\"><b>Developed By <a href=\"http://sorisoft.ml/\">SoRi Soft</a></b></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_a_"+xi+"\"></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_b_"+xi+"\"></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_c_"+xi+"\"></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_d_"+xi+"\"></div>";
								copy+="</div>";
					$("#mbody").append(copy);
					$("#slate").modal("show");
					//console.log(data);
					
					});
				}
			}
		}).fail(function() {
		});
		
	});
});
</script>';
}
?>