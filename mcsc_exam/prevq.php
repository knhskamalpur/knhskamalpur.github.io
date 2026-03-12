<?php
$q=$_GET['q'];
$meta=json_decode(file_get_contents('./qustions/'.$q),true);
//var_dump($meta);
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

$db=[
	'student'=>	[
				'name'	=>	'Arijit Kundu',
				'c/o'	=>	'Basudeb Kundu',
				'roll'	=>	'5645847646767'
				],
	'paper'=>	[
				'nos'	=>	2,
				'section'=>	[
							'1'	=>	[
									'name'	=>	'PERSONAL',
									'noq'	=>	2,
									'qustion'	=>	[
												'1'	=>	[
														'id'	=>	6,
														'ans'	=> 'NULL',
														'status'=>	'NULL',
														'q_txt' => 'What is your name?',
														'q_img'	=>	'',
														'opt_a_txt'	=>	'Arijit',
														'opt_a_img'	=>	'',
														'opt_b_txt'	=>	'Sukanta',
														'opt_b_img'	=>	'',
														'opt_c_txt'	=>	'Samir',
														'opt_c_img'	=>	'',
														'opt_d_txt'	=>	'Susant',
														'opt_d_img'	=>	''
														],
												'2'	=>	[
														'id'	=>	1,
														'ans'	=>	'NULL',
														'status'=>	'NULL',
														'q_txt' => '',
														'q_img'	=>	'./tick.png',
														'opt_a_txt'	=>	'Samar',
														'opt_a_img'	=>	'',
														'opt_b_txt'	=>	'Basudeb Kundu',
														'opt_b_img'	=>	'',
														'opt_c_txt'	=>	'Samir',
														'opt_c_img'	=>	'',
														'opt_d_txt'	=>	'',
														'opt_d_img'	=>	'./holder.png'
														],
												]
									],
							'2'	=>	[
									'name'	=>	'QQQQQQQQQ',
									'noq'	=>	2,
									'qustion'	=>	[
												'1'	=>	[
														'id'	=>	4,
														'ans'	=> 'NULL',
														'status'=>	'NULL',
														'q_txt' => 'What is your name?',
														'q_img'	=>	'NULL',
														'opt_a_txt'	=>	'Arijit',
														'opt_a_img'	=>	'NULL',
														'opt_b_txt'	=>	'Sukanta',
														'opt_b_img'	=>	'NULL',
														'opt_c_txt'	=>	'Samir',
														'opt_c_img'	=>	'NULL',
														'opt_d_txt'	=>	'Susant',
														'opt_d_img'	=>	'NULL'
														],
												'2'	=>	[
														'id'	=>	5,
														'ans'	=>	'NULL',
														'status'=>	'NULL',
														'q_txt' => 'What is your father name?',
														'q_img'	=>	'NULL',
														'opt_a_txt'	=>	'Samar',
														'opt_a_img'	=>	'NULL',
														'opt_b_txt'	=>	'Basudeb Kundu',
														'opt_b_img'	=>	'NULL',
														'opt_c_txt'	=>	'Samir',
														'opt_c_img'	=>	'NULL',
														'opt_d_txt'	=>	'Susant',
														'opt_d_img'	=>	'NULL'
														],
												]
									]
							]
				]
	];
	
$db['paper']=$PAPER;
$jdb=json_encode($db);
$jdb=str_replace('null','"NULL"',$jdb);
$jdb=str_replace('\r\n','<br>',$jdb);
$jdb=str_replace('\\"','\\\\"',$jdb);
//echo $jdb;
$totq=0;
foreach($db['paper']['section'] as $k=>$v){
	$totq+=$v['noq'];
}
//echo $jdb;
?>
<?php include 'header.php'; ?>
  <body>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Instruction</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="row">
			  <div class="col-md-4">.col-md-4</div>
			  <div class="col-md-4 ml-auto">.col-md-4 .ml-auto</div>
			</div>
			<div class="row">
			  <div class="col-md-3 ml-auto">.col-md-3 .ml-auto</div>
			  <div class="col-md-2 ml-auto">.col-md-2 .ml-auto</div>
			</div>
			<div class="row">
			  <div class="col-md-6 ml-auto">.col-md-6 .ml-auto</div>
			</div>
			<div class="row">
			  <div class="col-sm-9">
				Level 1: .col-sm-9
				<div class="row">
				  <div class="col-8 col-sm-6">
					Level 2: .col-8 .col-sm-6
				  </div>
				  <div class="col-4 col-sm-6">
					Level 2: .col-4 .col-sm-6
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
		  </div>
		</div>
	  </div>
	</div>
	
	
	
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="line-height:1;">
      <a class="navbar-brand" href="#">Online Exam</a>
	  <!--<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Show Instruction</button>
	  <!-- <div class="navbar-nav ml-auto text-white">
	  </div> -->
      <button class="navbar-toggler border-0 mr-0 pl-0 pr-0 text-secondary" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="glyphicon glyphicon-option-vertical"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item m-1 badge badge-pill badge-secondary">
            <span class="h6"><b>Name: </b>&nbsp;AAAAAAAAAAA. </span>
          </li>
          <li class="nav-item m-1 badge badge-pill badge-secondary">
            <span class="h6"><b>C/O: </b>&nbsp;BBBBBBBBB. </span>
          </li>
          <li class="nav-item m-1 badge badge-pill badge-secondary">
            <span class="h6"><b>Roll No: 999999999</b>&nbsp;</span>
          </li>
        </ul>
      </div>
    </nav>
	
	
	
	<div class="d-block" style="height:70px;"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-9 col-lg-9 pl-md-2 red_boxx">
				<div class="card mb-2">
				  <div class="card-header d-flex">
					<div class="h6 mt-1" id="hsec">Section: <?=$db['paper']['section']['1']['name']?></div>
					<div class="ml-auto">
						<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
							<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" title="Zoom in" id="zoomin">A+</button>
							<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" title="Reset zoom" id="zoomre">Reset</button>
							<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" title="Zoom out" id="zoomout">A-</button>
						</div>
					</div>
				  </div>
				  <div class="card-body" id="cardbody" style="max-height: 70vh; overflow-y: scroll;">
					<h5 class="card-title" id="title"><?='Qustion 1 of '.$totq.' :'?></h5>
					<p class="card-text">
					<div id="qustion">
						<?=$db['paper']['section']['1']['qustion']['1']['q_txt']?>
					</div>
					<br><br>
					<label for="opt_a">
						<input type="radio" name="ans" value="a" id="opt_a"/>
						<b id="opta">A) <?=$db['paper']['section']['1']['qustion']['1']['opt_a_txt']?></b>
					</label><br>
					<label for="opt_b">
						<input type="radio" name="ans" value="b" id="opt_b"/> 
						<b id="optb">B) <?=$db['paper']['section']['1']['qustion']['1']['opt_b_txt']?></b>
					</label><br>
					<label for="opt_c">
						<input type="radio" name="ans" value="c" id="opt_c"/> 
						<b id="optc">C) <?=$db['paper']['section']['1']['qustion']['1']['opt_c_txt']?></b>
					</label><br>
					<label for="opt_d">
						<input type="radio" name="ans" value="d" id="opt_d"/> 
						<b id="optd">D) <?=$db['paper']['section']['1']['qustion']['1']['opt_d_txt']?></b>
					</label><br>
					
					</p>
					
					
				  </div>
				  <div class="card-footer d-flex align-content-center flex-wrap justify-content-between">
						<button type="button" class="btn m-1 btn-info btn-sm" id="prev" disabled>Previons</button>
						<button type="button" class="btn m-1 btn-warning btn-sm" id="markreview">Mark for Review</button>
						<button type="button" class="btn m-1 btn-secondary btn-sm" id="clrres">Clear Response</button>
						<button type="button" class="btn m-1 btn-success btn-sm" id="save">Save</button>
						<button type="button" class="btn m-1 btn-success btn-sm" id="savenext">Save & Next</button>
				  </div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-3 col-lg-3 pr-md-2 pl-md-0 mt-xs-2 red_boxx">
				<div class="card mb-2">
				  <div class="card-header text-left h6">No. Box</div>
				  <div class="card-body" style="max-height: 70vh; overflow-y: scroll;">
					<div class="card-text">
<?php
for($i=1;$i<=$totq;$i++)
	echo '
						<button type="button" class="btn btn-sm m-1 border rounded" id="q_btn_'.$i.'" data-no="'.$i.'">'.$i.'</button>';
?>

					</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>
<script>
$(document).ready(function(){
		//$("div").last().hide();
	$(document).on('contextmenu',function(){
		return true;
	});
	var keys;
	var ctrl=17;
	var alt=18;
	var isCtrl=false;
	var isAlt=false;
	$(document).on('keydown',function(){
		e = (event || window.event) || window.event.keyCode;
		key = e.which;
		//console.log(key);
		if(key==ctrl)
			isCtrl=true;
		if(key==alt)
			isAlt=true;
		if(isCtrl && key==77)
			console.log('ctrl + M');
		if(isCtrl && key==8)
			console.log('clear');
		e.preventDefault();
	}).on('keyup',function(){
		e = (event || window.event) || window.event.keyCode;
		key = e.which;
		if(key==ctrl)
			isCtrl=false;
		if(key==alt)
			isAlt=false;
		e.preventDefault();
	});
	$(document).on('click',function(){
		if($("[data-target='#navbarCollapse']").is("[aria-expanded='true']")){
			$("#navbarCollapse").collapse('hide');
		}
	}); 
	var db=$.parseJSON('<?=$jdb?>');
	var cqn=0;
	var totq=totnqn();
	//load_qustion(++cqn);
	cqn++;
	var originalSize = $('#cardbody').css('font-size');
	// reset
	$("#zoomre").on('click',function(){
		$('#cardbody').css('font-size', originalSize);
	});

	// Increase Font Size
	$("#zoomin").on('click',function(){
		var currentSize = $('#cardbody').css('font-size');
		var currentSize = parseFloat(currentSize)*1.2;
		$('#cardbody').css('font-size', currentSize);
		return false;
	});

	// Decrease Font Size
	$("#zoomout").on('click',function(){
		var currentSize = $('#cardbody').css('font-size');
		var currentSize = parseFloat(currentSize)*0.8;
		$('#cardbody').css('font-size', currentSize);
		return false;
	});
	
	//---------------------------------------------
	
	$("[id^=q_btn_]").on('click',function(){
		cqn= $(this).attr('data-no');
		load_qustion(cqn);
	})
	
	$('#savenext').on('click',function(){
		var ans = $('input[name=ans]:checked').val();
		set_ans(cqn,ans);
		load_qustion(++cqn);
	});
	$('#save').on('click',function(){
		var ans = $('input[name=ans]:checked').val();
		set_ans(cqn,ans);
	});
	$('#clrres').on('click',function(){
		set_ans(cqn,'NULL');
	});
	$('#markreview').on('click',function(){
		var ans = $('input[name=ans]:checked').val();
		set_ans(cqn,ans);
		set_ans(cqn,'REVIEW');
	});
	$('#prev').on('click',function(){
		load_qustion(--cqn);
	});
	// halper functions----------------------------------------------------------
	function set_ans(qn,opt){
		var sec=qntosec(qn);
		var q=qntoqn(qn);
		switch(opt){
			case 'a':

			case 'b':
			case 'c':
			case 'd':
					db.paper.section[sec].qustion[q].ans=opt;
					db.paper.section[sec].qustion[q].status='SAVED';
					break;
			case 'NULL':
					db.paper.section[sec].qustion[q].ans='NULL';
					db.paper.section[sec].qustion[q].status='NULL';
					break;
			case 'REVIEW':
					db.paper.section[sec].qustion[q].status='REVIEW';
					break;
		}
	}
	
	function qntosec(qn){
		var nos=db.paper.nos;
		var i=1;
		if(qn <= db.paper.section[1].noq)
			return 1;
		else{
			for(i=1;i<nos && qn>db.paper.section[i].noq;i++){
				qn=qn-db.paper.section[i].noq;
			}
			return i;
		}
	}
	function qntoqn(qn){
		var nos=db.paper.nos;
		var i=1;
		if(qn <= db.paper.section[1].noq)
			return qn;
		else{
			for(i=1;i<nos && qn>db.paper.section[i].noq;i++){
				qn=qn-db.paper.section[i].noq;
			}
			return qn;
		}
	}
	function secqntoqn(sec,qn){
		var i=1;
		for(i=1;i<sec;i++){
			qn=qn+db.paper.section[i].noq;
		}
		return qn;
	}
	function totnqn(){
		var nos=db.paper.nos;
		var qn=0;
		var i=1;
		for(i=1;i<=nos;i++){
			qn=qn+db.paper.section[i].noq;
		}
		return qn;
	}
	function load_qustion(qn){
		var sec=qntosec(qn);
		var q=qntoqn(qn);
		//clear ans
		$('input[name=ans]:checked').prop('checked', false);
		// set buttons
		if(qn<=1){
			$('#prev').prop('disabled',true);
			$('#savenext').prop('disabled',false);
		}
		else if(qn>=totq){
			$('#savenext').prop('disabled',true);
			$('#prev').prop('disabled',false);
		}
		else{
			$('#prev').prop('disabled',false);
			$('#savenext').prop('disabled',false);
		}
		if(db.paper.section[sec].qustion[q].status == 'REVIEW'){
			$('#markreview').prop('disabled',true);
		}
		else{
			$('#markreview').prop('disabled',false);
		}
		//set pre ans
		switch(db.paper.section[sec].qustion[q].ans){
			case 'a': $('#opt_a').prop('checked',true); break;
			case 'b': $('#opt_b').prop('checked',true); break;
			case 'c': $('#opt_c').prop('checked',true); break;
			case 'd': $('#opt_d').prop('checked',true); break;
		}
			$('#opt_a')
		//load
		$('#hsec').html('Section: '+db.paper.section[sec].name);
		$('#title').html('Qustion '+cqn+' of '+totq + ' :');
		if(db.paper.section[sec].qustion[q].q_txt != '')
			$('#qustion').html(db.paper.section[sec].qustion[q].q_txt);
		else
			$('#qustion').html('<img src="' + db.paper.section[sec].qustion[q].q_img + '" style="width:100%;height:auto;"/>');
			
		if(db.paper.section[sec].qustion[q].opt_a_txt != '')
			$('#opta').html('A) '+db.paper.section[sec].qustion[q].opt_a_txt);
		else
			$('#opta').html('A) <img src="' + db.paper.section[sec].qustion[q].opt_a_img+ '" style="width:20%;height:auto;"/>');
		
		if(db.paper.section[sec].qustion[q].opt_b_txt != '')
			$('#optb').html('B) '+db.paper.section[sec].qustion[q].opt_b_txt);
		else
			$('#optb').html('B) <img src="' + db.paper.section[sec].qustion[q].opt_b_img+ '" style="width:20%;height:auto;"/>');
		
		if(db.paper.section[sec].qustion[q].opt_c_txt != '')
			$('#optc').html('C) '+db.paper.section[sec].qustion[q].opt_c_txt);
		else
			$('#optc').html('C) <img src="' + db.paper.section[sec].qustion[q].opt_c_img+ '" style="width:20%;height:auto;"/>');
		
		if(db.paper.section[sec].qustion[q].opt_d_txt != '')
			$('#optd').html('D) '+db.paper.section[sec].qustion[q].opt_d_txt);
		else
			$('#optd').html('D) <img src="' + db.paper.section[sec].qustion[q].opt_d_img+ '" style="width:20%;height:auto;"/>');
		
	}
});
</script>
