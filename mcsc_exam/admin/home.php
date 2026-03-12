<?php
include 'check_login.php';

//var_dump($_POST);
if(isset($_POST['submit'])){
	if($_POST['submit']=='OFF'){
		$meta=json_decode(file_get_contents('../qustions/'.$_POST['qs'].'.q'),true);
		$SEC=[];
		$SECC=0;
		$PAPER=['nos'=>0,'section'=>[]];
		foreach($meta['q'] as $k=>$v){
			//$v['qsec']
			if(!array_key_exists($v['qsec'],$SEC)){
				$SEC[$v['qsec']]=++$SECC;
				
				$PAPER['nos']=$SECC;
				$PAPER['section'][$SECC]['name']=$v['qsec'];
				$xc=$PAPER['section'][$SECC]['noq']=1;
				$PAPER['section'][$SECC]['qustion'][$xc]['id']=$k;
				$PAPER['section'][$SECC]['qustion'][$xc]['ans']='NULL';
				$PAPER['section'][$SECC]['qustion'][$xc]['status']='NULL';
				$PAPER['section'][$SECC]['qustion'][$xc]['q_txt']=@$v['q_txt'];
				$PAPER['section'][$SECC]['qustion'][$xc]['q_img']=@$v['q_img'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_a_txt']=@$v['opt_a_txt'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_a_img']=@$v['opt_a_img'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_b_txt']=@$v['opt_b_txt'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_b_img']=@$v['opt_b_img'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_c_txt']=@$v['opt_c_txt'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_c_img']=@$v['opt_c_img'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_d_txt']=@$v['opt_d_txt'];
				$PAPER['section'][$SECC]['qustion'][$xc]['opt_d_img']=@$v['opt_d_img'];
			}
			else{
				$SECN=$SEC[$v['qsec']];
				$xc=++$PAPER['section'][$SECN]['noq'];
				$PAPER['section'][$SECN]['qustion'][$xc]['id']=$k;
				$PAPER['section'][$SECN]['qustion'][$xc]['ans']='NULL';
				$PAPER['section'][$SECN]['qustion'][$xc]['status']='NULL';
				$PAPER['section'][$SECN]['qustion'][$xc]['q_txt']=@$v['q_txt'];
				$PAPER['section'][$SECN]['qustion'][$xc]['q_img']=@$v['q_img'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_a_txt']=@$v['opt_a_txt'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_a_img']=@$v['opt_a_img'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_b_txt']=@$v['opt_b_txt'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_b_img']=@$v['opt_b_img'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_c_txt']=@$v['opt_c_txt'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_c_img']=@$v['opt_c_img'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_d_txt']=@$v['opt_d_txt'];
				$PAPER['section'][$SECN]['qustion'][$xc]['opt_d_img']=@$v['opt_d_img'];
			}
		}
		file_put_contents('../exam.status',json_encode(['qustion'=>$_POST['qs'],'paper'=>$PAPER]));
	}
	if($_POST['submit']=='ON'){
		unlink('../exam.status');
	}
}
$title='Dashboard';
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
$exam_power=false;
if(file_exists('../exam.status')){
	$exam_power=true;
	$es='<input type="submit" name="submit" class="btn btn-primary btn-lg" value="ON"/>';
	$ss=json_decode(file_get_contents('../exam.status'),true);
	$qs=$ss['qustion'];
}
else{
	$es='<input type="submit" name="submit" class="btn btn-secondary btn-lg" value="OFF"/>';
	$qs='<select name="qs">';
	
	$dir=scandir('../qustions/');
	foreach($dir as $k){
		if(ext($k)=='q'){
			$qs.='<option value="'.rext($k).'">'.rext($k).'</option>';
		}
	}
	$qs.='</select>';
}

$dir=scandir('../candidates');
$nop=0;
$nosubmit=0;
foreach($dir as $k){
	if(ext($k)=='profile'){
		$nop++;
	}
	if(ext($k)=='submit')
		$nosubmit++;
}
echo '<div class="card login-form slate p-0 text-dark mx-4">
  <form method="post" action="" id="submit">
  <div class="card-header d-flex">
	<div>
		<b>No of Registered Candidate:</b> '.$nop.'<br>
		<b>No of Submited Answer Sheet:</b> '.$nosubmit.'<br>
		<b>Qustion Set:</b> '.$qs.'
	</div>
	<div class="ml-auto">
		Exam Status: '.$es.'
	</div>
  </div>
	</form>
  <div class="card-body">
    <!--<h5 class="card-title">Heading</h5>
    <p class="card-text">Text</p>
    <a href="#" class="btn btn-primary">BTN</a>-->
  </div>
  <div class="card-footer">
    <form method="post" action="get_result.php">
			<label for="qustion-set-name">Get Answer Sheet of: </label>
			<input type="text" name="roll" class="" placeholder="Candidate\'s Roll"/>
		
			<input type="submit" name="getans" value="GET"/>
	</form>
  </div>
</div>';
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