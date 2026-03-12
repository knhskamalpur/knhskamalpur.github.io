<?php
include 'check_login.php';
$title="Admin Panel";
include 'header.php';

/*echo '
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
          <li class="nav-item">
            <a class="nav-link text-sori-green" href="setting">Setting</a>
          </li>
        </ul>
      </div>
</nav>
<div class="d-block" style="height:65px;"></div>';*/

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
echo '<table>';
$dir=scandir('../candidates');
foreach($dir as $k){
	if(ext($k)=='profile'){
		$metadata=json_decode(file_get_contents('../candidates/'.$k),true);
		/*echo '<div class="row d-flex justify-content-around mt-1">
			<div class="col border border-dark">Candidate Name</div>
			<div class="col border border-dark">C/O</div>
			<div class="col border border-dark">D.O.B.</div>
			<div class="col border border-dark">Registration No</div>
<div class="col border border-dark">Mobile No</div>

			<div class="col border border-dark">Roll No</div>
			<div class="col border border-dark">Date-Time</div>
		</div>';*/
		echo '<tr>
			<td> '.$metadata['candidate-name'].'</td>
			<td> '.$metadata['c-o'].'</td>
			<td> '.$metadata['dob'].'</td>
			<td> '.$metadata['registration-no'].'</td>
<td> '.@$metadata['mobile-no'].'</td>

			<td> '.$metadata['roll-no'].'</td>
			<td> '.$metadata['exam-date'].'  '.$metadata['batch'].'</td>
		</tr>';
		//var_dump($metadata);
	}
}
echo '</table>';
//var_dump($_SESSION);
//include 'footer.php';
?>

<script>
$(document).ready(function(){
	/*$(document).click(function(){
		if($("[data-target='#navbarCollapse']").is("[aria-expanded='true']")){
			$("#navbarCollapse").collapse('hide');
		}
	});*/
});
</script>