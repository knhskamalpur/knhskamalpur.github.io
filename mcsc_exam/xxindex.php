<?php
$p=true;
$msg='';
if(isset($_POST['roll'])){
	unset($_POST['go']);
	if(file_exists('./candidates/'.$_POST['roll'].'.profile')){
		$p=false;
		header("Location: ./dash.php?d=".base64_encode(json_encode($_POST)));
		exit;
	}
	else{
		$msg='Invalid.';
		$p=true;
	}
}

if($p){
$title='Login';
include 'header.php';
	echo'
  <body>
	<div class="container-fluid">
		<div class="row justify-content-md-center mt-3" id="load">
			<div class="col-auto h2 ">'.$msg.'</div>
		</div>
		<div class="row">
			<div class="col">
				
			</div>
			<div class="col-xs-10 col-sm-8 col-md-4 red_boxx">
				<div class="card mt-5">
					<div class="card-header">
						<h4 class="card-title">Login</h4>
					</div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
						  <div class="form-group">
							<label for="exampleInputEmail1">Roll No: </label>
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon1">Roll No: </span>
							  <input type="text" name="roll" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Roll No" autocomplete="off">
							</div>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Date of Birth:</label>
							<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1">Date of Birth:</span>
							<input type="text" name="dob" class="form-control" value="" id="exampleInputPassword1" placeholder="Enter Password" autocomplete="off">
							</div>
						  </div>
						  <!--<div class="form-check">
							<label class="form-check-label">
							  <input type="checkbox" class="form-check-input">
							  Check me out
							</label>
						  </div>-->
						  <input type="submit" name="go" class="btn btn-primary w-100" value="Login"/>
						</form>
					</div>
				</div>
			</div>
			<div class="col">
				
			</div>
		</div>
	</div>
	
	<nav class="navbar fixed-bottom navbar-light bg-light">
		<div class="navbar-brand mx-auto h5">Developed By <b> SoRi Soft</b></a></div>
	</nav>
	';
include 'footer.php';
echo '<script>
$(document).ready(function(){
	//$("div").last().hide();
});
</script>';
}
?>