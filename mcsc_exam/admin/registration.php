<?php
include 'check_login.php';

if(!file_exists('../candidates/metadata.file')){
	$_SESSION['msg']='red|Candidate\'s Datafile corrupted.';
	header("location:  home.php",true,303);
	exit;
}
else{
	$metadata=json_decode(file_get_contents('../candidates/metadata.file'),true);
}

if(isset($_GET['opt']))
switch($_GET['opt']){
	case 'del_all':	
					$dir=scandir('../candidates');
					foreach($dir as $k){
						if(ext($k)=='profile'){
							unlink('../candidates/'.$k);
						}
					}
					$metadata['noc']=0;
					file_put_contents('../candidates/metadata.file',json_encode($metadata));
					break;
}
//file_put_contents('../candidates/metadata.file',json_encode(['noc'=>0]));
if(isset($_POST['roll-no'])){
		if(file_put_contents('../candidates/'.$_POST['roll-no'].'.profile',json_encode($_POST))){
			$_SESSION['msg']='green|Profile(No: '.++$metadata['noc'].') Saved.';
			@unlink('../candidates/'.$_POST['roll-no'].'.qustion');
			@unlink('../candidates/'.$_POST['roll-no'].'.ans');
			@unlink('../candidates/'.$_POST['roll-no'].'.submit');
			file_put_contents('../candidates/metadata.file',json_encode($metadata));
		}
}

$title='Candidate Registration';
include 'header.php';

echo '
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="line-height:1;">
      <a class="navbar-brand" href="#">aPanel</a>
	  
      <button class="navbar-toggler border-0 mr-0 pl-0 pr-0 text-secondary" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="glyphicon glyphicon-option-vertical"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-sori-green" href="home.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-sori-green" href="registration.php">Registration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-sori-green" href="qustion.php">Qustion</a>
          </li>
        </ul>
      </div>
</nav>
<div class="d-block" style="height:65px;"></div>';

if(isset($_SESSION['msg'])) {
	$ast=explode('#',$_SESSION['msg']);
	foreach($ast as $stv) {
		$st=explode('|',$stv);
		echo '
			<div class="container alert alert-dismissible fade show" id="mSg" role="alert">
				<div class="row" align="left">
					<div style="height: 7vh;"></div>
					<div class="col-xs-1 col-sm-1 col-md-4 col-lg-4 visible-xs visible-sm visible-md visible-lg"></div>
					<div class="col-xs-10 col-sm-10 col-md-4 col-lg-4 '.@$st[0].'">
						<div class="i_i">
						'.@$st[1].'
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span class="glyphicon glyphicon-remove"></span>
						  </button>
						</div>
					</div>
				</div>
			</div>';
	}
	unset($_SESSION['msg']);
}

echo '
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-10 col-sm-10 col-md-8 col-lg-8">
			<div class="card login-form p-0 text-dark">
			  <div class="card-header d-flex">
				<div>
					<div class="h4 text-sori-blue">Registration Form</div><br>
					<b>For Profile No: </b>'.($metadata['noc']+1).'
				</div>
				<div class="ml-auto">
					<a href="viewallpro.php" class="btn btn-sm m-1 btn-primary" role="button">View All Profiles</a>
					<!a href="?opt=del_all" class="btn btn-sm m-1 btn-danger" role="button"></a>
				</div>
			  </div>
			  <div class="card-body">
					<form method="post" action="" id="submit" class="slate">
						<div class="filds">
							<label for="candidate-name">Candidate Name:</label>
							<input type="text" name="candidate-name" class="" placeholder="Candidate Name" value=""/>
						</div>
						<div class="filds">
							<label for="c-o">C/O:</label>
							<input type="text" name="c-o" class="input" placeholder="C/O" value=""/>
						</div>
						<div class="filds">
							<label for="dob">Date of Birth:</label>
							<input type="date" name="dob" class="input" placeholder="Date of Birth" value=""/>
						</div>
						<div class="filds">
							<label for="registration-no">Registration No:</label>
							<input type="text" name="registration-no" class="input" placeholder="Registration No" value=""/>
						</div>


						<div class="filds">
							<label for="mobile-no">Mobile No:</label>
							<input type="text" name="mobile-no" class="input" placeholder="Mobile No" value=""/>
						</div>

						<div class="filds">
							<label for="roll-no">Roll No:</label>
							<input type="text" name="roll-no" class="input" placeholder="Roll No" value=""/>
						</div>
						<div class="filds">
							<label for="exam-date">Exam Date:</label>
							<input type="date" name="exam-date" class="input" placeholder="Exam Date" value=""/>
						</div>
						<div class="filds">
							<label for="batch">Time:</label>
							<input type="time" name="batch" class="input" placeholder="Batch" value=""/>
						</div>
					</form>
			  </div>
			  <div class="card-footer d-flex">
				<div class="ml-auto"><button type="button" onclick="submit.submit()" class="btn m-1 btn-primary bg-sori-blue text-sori-green">SUBMIT</button></div>
			  </div>
			</div>
		</div>
	</div>
</div>
';

include 'footer.php';
?>

<script>
$(document).ready(function(){
	$(document).click(function(){
		if($("[data-target='#navbarCollapse']").is("[aria-expanded='true']")){
			$("#navbarCollapse").collapse('hide');
		}
	});
});
</script>