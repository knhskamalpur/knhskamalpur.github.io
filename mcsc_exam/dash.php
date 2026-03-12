<?php
$d=$_GET['d'];
$d=base64_decode($d);
$d=json_decode($d,true);
$metadata=json_decode(file_get_contents('./candidates/'.$d['roll'].'.profile'),true);

$title='Information';
include 'header.php';
echo '
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="line-height:1;">
      <a class="navbar-brand" href="#">Online Exam</a>
	  <!-- <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Show Instruction</button>
	  <!-- <div class="navbar-nav ml-auto text-white">
	  </div> -->
      <button class="navbar-toggler border-0 mr-0 pl-0 pr-0 text-secondary" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="glyphicon glyphicon-option-vertical"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item m-1 badge badge-pill badge-secondary">
            <span class="h6"><b>Name: </b>&nbsp;'.$metadata['candidate-name'].'. </span>
          </li>
          <li class="nav-item m-1 badge badge-pill badge-secondary">
            <span class="h6"><b>C/O: </b>&nbsp;'.$metadata['c-o'].'. </span>
          </li>
          <li class="nav-item m-1 badge badge-pill badge-secondary">
            <span class="h6"><b>Roll No: '.$metadata['roll-no'].'</b>&nbsp;</span>
          </li>
        </ul>
      </div>
    </nav>
	<div class="d-block" style="height:70px;"></div>
	
	<div class="container">
			<div class="row border border-dark my-3 justify-content-md-center">
			  <div class="col-3 h6">Candidate Name: </div>
			  <div class="col-3" id="cname">'.$metadata['candidate-name'].'</div>
			</div>
			<div class="row border border-dark my-3 justify-content-md-center">
			  <div class="col-3 h6">C/O: </div>
			  <div class="col-3" id="fname">'.$metadata['c-o'].'</div>
			</div>
			<div class="row border border-dark my-3 justify-content-md-center">
			  <div class="col-3 h6">Date of Birth: </div>
			  <div class="col-3" id="ddob">'.$metadata['dob'].'</div>
			</div>
			<div class="row border border-dark my-3 justify-content-md-center">
			  <div class="col-3 h6">Registration No: </div>
			  <div class="col-3" id="rno">'.$metadata['registration-no'].'</div>
			</div>
			<div class="row border border-dark my-3 justify-content-md-center">
			  <div class="col-3 h6">Roll No: </div>
			  <div class="col-3" id="roll">'.$metadata['roll-no'].'</div>
			</div>
			<div class="row border border-dark my-3 justify-content-md-center">
			  <div class="col-3 h6">Date-Time: </div>
			  <div class="col-3" id="ddt">'.$metadata['exam-date'].' '.$metadata['batch'].'</div>
			</div>
			<div class="row my-3 justify-content-md-center">
			  <div class="col-3 h6 d-flex flex-wrap justify-content-between">
				<a href="trial.php?roll='.$metadata['roll-no'].'" type="button" class="btn m-1 btn-warning btn-sm" id="markreview" role="button">Trial Exam</a>
				<button type="button" class="btn m-1 btn-info btn-sm" id="goto">Go To Exam</button>
			  </div>
			</div>
	</div>
	';
	
include 'footer.php'; ?>
<script>

$(document).ready(function(){

	$("#goto").on("click",function(){
		$.ajax({
			type: "POST",
			url: "exam.php",
			dataType: "text",
			data: "roll=<?=$metadata['roll-no']?>",
			success: function(msg){
				console.log(msg);
				if(msg=="DONE")
					window.location="home.php?roll=<?=$metadata['roll-no']?>";
				else if(msg=="FAIL")
					alert('Exam not started');
			}
		}).fail(function() {
			
		});
		
	});
});
</script>