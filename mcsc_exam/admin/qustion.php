<?php
include 'check_login.php';

if(isset($_GET['opt']) and $_GET['opt']=='newq' and isset($_POST['qustion-set-name'])){
if(file_put_contents('../qustions/'.$_POST['qustion-set-name'].'.q',json_encode(['totq'=>0,'q'=>array()]))){
		$_SESSION['msg']='green|<b>'.$_POST['qustion-set-name'].'</b> Added Successfully. Ready for Qustion Entry.';
		header('location: ' . basename(__FILE__).'?q='.$_POST['qustion-set-name'].'.q',true,303);
		exit;
	}
}

$title='Qustion Papers';
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
		<div class="card login-form p-0 text-dark">';


if(isset($_GET['opt'])){
	if($_GET['opt']=='newq'){
		if(!isset($_POST['qustion-set-name']))
		echo '<div class="card-header d-flex"><div class="h4">Adding Qustion Set...</div></div>
		<div class="card-body">
			<form method="post" action="" id="submit" class="slate">
				<div class="filds">
					<label for="qustion-set-name">Qustion Set Name: (A-Z,a-z,0-9,-,_) no space. </label>
					<input type="text" name="qustion-set-name" class="" pattern="[A-Za-z0-9]" placeholder="Qustion Set Name"/>
				</div>
			</form>
		</div>
		<div class="card-footer d-flex">
			<div class="ml-auto"><button type="button" onclick="submit.submit()" class="btn m-1 btn-primary bg-sori-blue text-sori-green">Next...</button></div>
		</div>
		';
	}
}
		
elseif(isset($_GET['q'])){
	$q=$_GET['q'];
	if(isset($_GET['qn']))
		$qn=$_GET['qn'];
	else{
		echo '<script>window.location="'.basename(__FILE__).'?q='.$q.'&qn=1";</script>';
	}
		//$qn=1;
	
	
	if(file_exists('../qustions/'.$q)){
		$meta=json_decode(file_get_contents('../qustions/'.$q),true);
	}
	if(isset($_GET['opt']) and $_GET['opt']=='delq'){
		unset($meta['q'][$qn]);
		file_put_contents('../qustions/'.$q,json_encode($meta));
		echo '<script>window.location="'.basename(__FILE__).'?q='.$q.'&qn='.$qn.'";</script>';
	}
	if(isset($_POST['qsec'])){
		//var_dump($_POST);
		//var_dump($_FILES);
		if(file_exists('../qustions/'.$q)){
			if(!isset($meta['q'][$qn]['qsec'])){
				$meta['totq']++;
				$meta['q'][$qn]=$_POST;
			}
			else
				$meta['q'][$qn]=array_merge($meta['q'][$qn], $_POST);
			if($_POST['q_txt']=='' and $_FILES['q_img']['error']==0){
				$fname=$q.'_'.$qn.'_q.'.strtolower(ext($_FILES['q_img']['name']));
				move_uploaded_file($_FILES['q_img']['tmp_name'],'../qustions/'.$fname);
				$meta['q'][$qn]['q_img']='./qustions/'.$fname;
			}
			if($_POST['opt_a_txt']=='' and $_FILES['opt_a_img']['error']==0){
				$fname=$q.'_'.$qn.'_a.'.strtolower(ext($_FILES['opt_a_img']['name']));
				move_uploaded_file($_FILES['opt_a_img']['tmp_name'],'../qustions/'.$fname);
				$meta['q'][$qn]['opt_a_img']='./qustions/'.$fname;
			}
			if($_POST['opt_b_txt']=='' and $_FILES['opt_b_img']['error']==0){
				$fname=$q.'_'.$qn.'_b.'.strtolower(ext($_FILES['opt_b_img']['name']));
				move_uploaded_file($_FILES['opt_b_img']['tmp_name'],'../qustions/'.$fname);
				$meta['q'][$qn]['opt_b_img']='./qustions/'.$fname;
			}
			if($_POST['opt_c_txt']=='' and $_FILES['opt_c_img']['error']==0){
				$fname=$q.'_'.$qn.'_c.'.strtolower(ext($_FILES['opt_c_img']['name']));
				move_uploaded_file($_FILES['opt_a_img']['tmp_name'],'../qustions/'.$fname);
				$meta['q'][$qn]['opt_c_img']='./qustions/'.$fname;
			}
			if($_POST['opt_d_txt']=='' and $_FILES['opt_d_img']['error']==0){
				$fname=$q.'_'.$qn.'_d.'.strtolower(ext($_FILES['opt_d_img']['name']));
				move_uploaded_file($_FILES['opt_d_img']['tmp_name'],'../qustions/'.$fname);
				$meta['q'][$qn]['opt_d_img']='./qustions/'.$fname;
			}
			file_put_contents('../qustions/'.$q,json_encode($meta));
			//$qn++;
			echo '<script>window.location="'.basename(__FILE__).'?q='.$q.'&qn='.($qn+1).'";</script>';
		}
	}

	echo '
	<div class="card-header d-flex" xstyle="width:75vw;">
		<div>
			<div class="h5">Qustion Set: '.rext($q).'</div>
			<div class="h5">Qustion No: '.$qn.'</div>
		</div>
		<div class="ml-auto"><a href="../prevq.php?q='.$q.'" class="btn btn-sm m-1 btn-primary">Preview Whole Qustion</a></div>
	</div>
	<div class="card-body p-1">
		<form method="post" action="" id="submit" class="xslate" enctype="multipart/form-data">
			<div class="filds">
				<label for="opt_a">Qustion Section:</label>
				<input type="text" name="qsec" class="slate_input" placeholder="Section Name" value="'.@$meta['q'][$qn]['qsec'].'" style="box-shadow: none;padding:3px;border-radius: 3px;color: var(--sori-blue);width: auto;"/>
			</div>
			<div class="filds">
				<label for="q_txt">Qustion Text:</label><br>
				<textarea name="q_txt" class="" placeholder="Qustion" value="" style="width:70vw;height:10vh;resize:auto;">'.@$meta['q'][$qn]['q_txt'].'</textarea>
			</div>
			<div class="filds">
				<label for="q_img">Qustion Image:</label>
				<input id="q_img_input" type="file" name="q_img" class="" placeholder="Qustion Image" accept=".gif,.png,.jpg"/>
				<br>
				<img id="q_img" width="100%" height="70vh" style="max-width: 70vw;" src="'.(@$meta['q'][$qn]['q_img']!=''?'.'.@$meta['q'][$qn]['q_img']:'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==').'" alt="Qustion Image">
			</div>
			<br>
			<div class="filds">
				<label for="opt_a">Option A:</label>
				<input type="radio" name="rans" value="a" '.(@$meta['q'][$qn]['rans']=='a' ? 'checked':'').'/>
				<input type="text" name="opt_a_txt" class="slate_input" placeholder="Option A" value="'.@$meta['q'][$qn]['opt_a_txt'].'" style="box-shadow: none;padding:3px;border-radius: 3px;color: var(--sori-blue);width: auto;"/>
				 OR <input type="file" id="opt_a_input" name="opt_a_img" class="" placeholder="Option Image" accept=".gif,.png,.jpg"/>
				 <img id="opt_a" width="40%" height="50px" style="max-width: 10vw;" src="'.(@$meta['q'][$qn]['opt_a_img']!=''?'.'.@$meta['q'][$qn]['opt_a_img']:'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==').'" alt="Option A Image">
				 
			</div>
			<div class="filds">
				<label for="opt_b">Option B:</label>
				<input type="radio" name="rans" value="b" '.(@$meta['q'][$qn]['rans']=='b' ? 'checked':'').'/>
				<input type="text" name="opt_b_txt" class="slate_input" placeholder="Option B" value="'.@$meta['q'][$qn]['opt_b_txt'].'" style="box-shadow: none;padding:3px;border-radius: 3px;color: var(--sori-blue);width: auto;"/>
				 OR <input type="file" id="opt_b_input" name="opt_b_img" class="" placeholder="Option Image" accept=".gif,.png,.jpg"/>
				 <img id="opt_b" width="40%" height="50px" style="max-width: 10vw;" src="'.(@$meta['q'][$qn]['opt_b_img']!=''?'.'.@$meta['q'][$qn]['opt_b_img']:'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==').'" alt="Option B Image">
			</div>
			<div class="filds">
				<label for="opt_c">Option C:</label>
				<input type="radio" name="rans" value="c" '.(@$meta['q'][$qn]['rans']=='c' ? 'checked':'').'/>
				<input type="text" name="opt_c_txt" class="slate_input" placeholder="Option C" value="'.@$meta['q'][$qn]['opt_c_txt'].'" style="box-shadow: none;padding:3px;border-radius: 3px;color: var(--sori-blue);width: auto;"/>
				 OR <input type="file" id="opt_c_input" name="opt_c_img" class="" placeholder="Option Image" accept=".gif,.png,.jpg"/>
				 <img id="opt_c" width="40%" height="50px" style="max-width: 10vw;" src="'.(@$meta['q'][$qn]['opt_c_img']!=''?'.'.@$meta['q'][$qn]['opt_c_img']:'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==').'" alt="Option C Image">
			</div>
			<div class="filds">
				<label for="opt_d">Option D:</label>
				<input type="radio" name="rans" value="d" '.(@$meta['q'][$qn]['rans']=='d' ? 'checked':'').'/>
				<input type="text" name="opt_d_txt" class="slate_input" placeholder="Option D" value="'.@$meta['q'][$qn]['opt_d_txt'].'" style="box-shadow: none;padding:3px;border-radius: 3px;color: var(--sori-blue);width: auto;"/>
				 OR <input type="file" id="opt_d_input" name="opt_d_img" class="" placeholder="Option Image" accept=".gif,.png,.jpg"/>
				 <img id="opt_d" width="40%" height="50px" style="max-width: 10vw;" src="'.(@$meta['q'][$qn]['opt_d_img']!=''?'.'.@$meta['q'][$qn]['opt_d_img']:'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==').'" alt="Option D Image">
			</div>
		</form>
		
	</div>
	<div class="card-footer d-flex">
		<div class="ml-auto"><button type="button" onclick="submit.submit()" class="btn m-1 btn-primary bg-sori-blue text-sori-green">Save and Add Next</button></div>
	</div>
	<div class="card-footer d-flex flex-wrap">
	';
	foreach($meta['q'] as $k=>$w){
		if($k==$qn)
			echo '<a class="btn btn-sm m-1 btn-secondary" role="button" href="'.basename(__FILE__).'?q='.$q.'&qn='.$k.'">'.$k.'</a>';
		else
			echo '<a class="btn btn-sm m-1 btn-primary" role="button" href="'.basename(__FILE__).'?q='.$q.'&qn='.$k.'">'.$k.'</a>';
	}
		
	echo '</div>';
}
else{
	echo '
	<div class="card-header d-flex">
		<div>
			<div class="h4">Qustion Set List</div>
		</div>
		<div class="ml-auto"><a href="?opt=newq" class="btn btn-sm m-1 btn-primary">Add Qustion Set</a></div>
	</div>
	<div class="xcard-body">
		<div class="list-group border-0">';
	$i=0;
	$dir=scandir('../qustions/');
	foreach($dir as $k){
		if(ext($k)=='q'){
			$meta=json_decode(file_get_contents('../qustions/'.$k),true);
			echo '<a href="?q='.$k.'&qn='.($meta['totq']+1).'" class="list-group-item list-group-item-action flex-column align-items-start" style="background:rgba(0,0,0,0);">
					<div class="d-flex w-100 justify-content-between">
					  <h5 class="mb-1">'.(++$i).') '.rext($k).'</h5>
					</div>
					<p class="mb-1">No of Qustion:	'.$meta['totq'].'</p>
				  </a>';
		}
	}
	echo '</div></div>';
}
echo '</div><div></div>';
include 'footer.php';
?>

<script>
$(function(){
	
	function gogogo(){
		
	}
});

$(document).ready(function(){
	$(document).click(function(){
		if($("[data-target='#navbarCollapse']").is("[aria-expanded='true']")){
			$("#navbarCollapse").collapse('hide');
		}
	});
	$('input[type="file"]').on( 'change', function() {
		iid='#' + $(this).attr('id').replace('_input','');
		console.log(iid);
	   myfile= $( this ).val();
	   var ext = myfile.split('.').pop();
	   if(ext=="gif" || ext=="png" || ext=="jpg"){
		   /*if(ext=="png" || ext=="jpg")
		   readURL(this,iid);
			else if(ext=="gif")
				$(iid).attr('src', '../img/gif.png'); --- old code*/
			/*new code*/
		   readURL(this,iid);
	   } else{
		   $(this).val('');
			$(iid).attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==');
		   alert('Only .jpg,.png,.gif files are allowed.');
	   }
	});
	function readURL(input,iid) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$(iid).attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#submit').on('submit',function(e){
		alert($('input[name="qsec"]').val());
		return false;
	});
});
</script>
