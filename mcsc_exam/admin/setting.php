<?php
include 'check_login.php';
$title="Admin Panel";
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
          <li class="nav-item">
            <a class="nav-link text-sori-green" href="setting">Setting</a>
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

//var_dump($_SESSION);
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