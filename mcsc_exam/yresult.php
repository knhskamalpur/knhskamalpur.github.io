<?php
include 'func.php';
if(isset($_POST['roll'])){
$o=var_export($_POST,true);
file_put_contents('data.txt',$o);
	$dir='./candidates';
	$find=false;
	if(file_exists($dir.'/'.$_POST['roll'].'.qustion')){
		$metadata=json_decode(file_get_contents($dir.'/'.$_POST['roll'].'.qustion'),true);
			$jdb=json_encode($metadata);
			$jdb=str_replace('null','"NULL"',$jdb);
			$jdb=str_replace('\r\n','<br>',$jdb);
			$jdb=str_replace('\\"','\\\\"',$jdb);
		$jdb=json_encode($metadata);
		echo $jdb;
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
	<div class="container-fluid">
		<div class="row d-none justify-content-md-center mt-3" id="load">
			<div class="col-auto h2">Loading...</div>
		</div>
		<div class="row" id="iform">
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
		
		
		  <div class="card mt-2" id="mbodyx" style="display:none;">
			<div class="card-header d-flex">
				<div class="h5 mt-1">Report Card Download</div>
				<div class="ml-auto">
					<button type="button" class="btn btn-danger d-print-none" id="cls" role="button">Close</button>
					<button type="button" class="btn btn-secondary d-print-none" onclick="window.print()" role="button">Print</button>
				</div>
			</div>
			<div class="row m-1">
			  <div class="col border rounded" id="cname"></div>
			  <div class="col border rounded" id="fname"></div>
			  <div class="col border rounded" id="ddob"></div>
			  <div class="col border rounded" id="rno"></div>
			  <div class="col border rounded" id="roll"></div>
			  <div class="col border rounded" id="ddt"></div>
			</div>
			<div class="row m-3 mx-1 p-1 border">
			  <div class="col"><b>Correct: </b><span id="cans"></span></div>
			  <div class="col"><b>Wrong: </b><span id="wans"></span></div>
			</div>
		  </div>
		
	</div>
	
	<div class="d-block" style="height:70px;"></div>
	<nav class="navbar fixed-bottom navbar-light bg-light" id="footer">
		<div class="navbar-brand mx-auto h5">Developed By <a href="http://sorisoft.ml/">SoRi Soft</a></div>
	</nav>
	';
include 'footer.php';	
echo '
<script>
$(document).ready(function(){

	$("#cls").on("click",function(){
		$("#mbodyx").hide();
		$("#iform").show();
	});
	$("#dwn").on("click",function(){
		$("#iform").hide();
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
				if(msg=="FAIL"){
					alert("Invalid Information.");
					$("#load").toggleClass("d-none");
					$("#iform").show();
				}
				else{
					data=JSON.parse(msg);
					console.log(msg);
					console.log(data);
					console.log("candidates/"+roll+".profile");
					$.getJSON( "candidates/"+roll+".profile", function( data_std ) {
					console.log(data_std);
					document.title="Report Card of " + data_std["candidate-name"] + " - " + data_std["roll-no"] + " :: SoRi Soft";
					$("#cname").html(data_std["candidate-name"]);
					$("#fname").html(data_std["c-o"]);
					$("#ddob").html(data_std["dob"]);
					$("#rno").html(data_std["registration-no"]);
					$("#roll").html(data_std["roll-no"]);
					$("#ddt").html(data_std["exam-date"] + " - " + data_std["batch"]);
					var Q;
					$.getJSON( "qustions/set-1.q", function( QN ) {
						Q=QN;
						console.log(QN);
					
					var xi=0;
					var cans=0;
					var wans=0;
            					$.getJSON( "candidates/"+roll+".ans", function( W ) {
            					console.log(W);
					$.each( data.paper.section, function( k1, v1 ) {
						$.each( v1.qustion, function( k2, v2 ) {
							++xi;
							var holder="<img src=\"holder.png\" style=\"width:12px;height:12px;\"/> ";
							var tick="<img src=\"tick.png\" style=\"width:12px;height:12px;\"/> ";
							var ht="";
								ht+="<div class=\"row my-1 mx-2 p-1 border border-dark delrow\" id=\"row_"+xi+"\">";
								  ht+="<div class=\"col-12\" style=\"overflow-wrap: break-word;\" id=\"q_"+xi+"\"><b>"+xi+". </b></div>";
								  ht+="<div class=\"col mb-1 \" style=\"overflow-wrap: break-word;\" id=\"opt_a_"+xi+"\"></div>";
								  ht+="<div class=\"col mb-1 \" style=\"overflow-wrap: break-word;\" id=\"opt_b_"+xi+"\"></div>";
								  ht+="<div class=\"col mb-1 \" style=\"overflow-wrap: break-word;\" id=\"opt_c_"+xi+"\"></div>";
								  ht+="<div class=\"col mb-1 \" style=\"overflow-wrap: break-word;\" id=\"opt_d_"+xi+"\"></div>";
								ht+="</div>";
								$("#mbodyx").append(ht);
								var v3=v2;
								v2=Q.q[v2.id];
								if(v2.q_txt != "")
									$("#q_"+xi).append(v2.q_txt);
								else
									$("#q_"+xi).append("<img src=\"+v2.q_img+\" style=\"width:100%;height:auto;\"/>");
									
								$("#q_"+xi).append("<span class=\"border rounded text-muted ml-5\" id=\"flag\">SoRi Soft</span>");
									
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
							var R=v2.rans;
							v3=W[v3.id];
							$("#opt_"+R+"_"+xi).addClass("border border-dark rounded");
							$.each([ "a","b","c","d" ], function( dx, vl ) {
								if(v3.ans==vl)
									$("#opt_"+vl+"_"+xi).prepend(tick);
								else
									$("#opt_"+vl+"_"+xi).prepend(holder);
							});
							
							if( v3.ans!="NULL"){
								if(v3.ans==R)
									cans++;
								else
									wans++;
								$("#cans").html(cans);
								$("#wans").html(wans);
							}
							//-------------
						});
					});
					var copy="<div class=\"row mt-3 m-2 p-1 border rounded text-center delrow\" id=\"row_x\">";
								  copy+="<div class=\"col-12\" style=\"overflow-wrap: break-word;\"><b>Developed By <a href=\"http://sorisoft.ml/\">SoRi Soft</a></b></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_a_"+xi+"\"></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_b_"+xi+"\"></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_c_"+xi+"\"></div>";
								  //copy+="<div class=\"col-6 my-1 p-1\" style=\"overflow-wrap: break-word;\" id=\"opt_d_"+xi+"\"></div>";
								copy+="</div>";
					$("#mbodyx").append(copy);
					$("#load").toggleClass("d-none");
					$("#mbodyx").show();
					//$("#slate").modal("show");
					//console.log(data);
							    });
					
					});
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
