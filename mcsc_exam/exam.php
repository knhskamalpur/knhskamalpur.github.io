<?php
include 'func.php';
if(file_exists('exam.status') && isset($_POST['roll'])){
       if(!file_exists('./candidates/'.$_POST['roll'].'.qustion')){
	$jdb=file_get_contents('exam.status');
	$jdb=json_decode($jdb,true);
	$jdb['paper']['section']=shuffle_array($jdb['paper']['section']);
	foreach($jdb['paper']['section'] as $i=>$r){
		$jdb['paper']['section'][$i]['qustion']=shuffle_array($r['qustion']);
	}
	$jdb=json_encode($jdb);
	//$jdb=str_replace('null','"NULL"',$jdb);
	//$jdb=str_replace('\r\n','<br>',$jdb);
	//$jdb=str_replace('\\"','\\\\"',$jdb);
	//echo $jdb;
	file_put_contents('./candidates/'.$_POST['roll'].'.qustion',$jdb);
}
	echo 'DONE';
}
else
	echo 'FAIL';

function shuffle_array($r){
	$shuffled_array = array();

	$keys = array_keys($r);
	shuffle($keys);
	$i=1;
	foreach ($keys as $key)
	{
		$shuffled_array[$i++] = $r[$key];
	}
	return $shuffled_array;
}
?>