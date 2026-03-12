<?php
include 'func.php';
$meta=[];
if(isset($_POST['id'])){
	if(file_exists('./candidates/'.$_POST['roll'].'.ans')){
		$meta=json_decode(file_get_contents('./candidates/'.$_POST['roll'].'.ans'),true);
	}
	$meta[$_POST['id']]=['ans'=>$_POST['ans'],'status'=>$_POST['status']];
	$meta['time']=$_POST['time'];
	file_put_contents('./candidates/'.$_POST['roll'].'.ans',json_encode($meta));
}
if(isset($_POST['ttime'])){
	if(file_exists('./candidates/'.$_POST['roll'].'.ans')){
		$meta=json_decode(file_get_contents('./candidates/'.$_POST['roll'].'.ans'),true);
	}
	$meta['time']=$_POST['ttime'];
	file_put_contents('./candidates/'.$_POST['roll'].'.ans',json_encode($meta));
}

if(isset($_POST['submit'])){
	if(file_put_contents('./candidates/'.$_POST['roll'].'.submit',$_POST['submit']))
	echo $_POST['submit'];
}
?>
