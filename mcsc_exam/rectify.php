<?php
include 'func.php';

$dir=scandir('./candidates');
foreach($dir as $k){
	if(ext($k)=='profile'){
	$metadata=json_decode(file_get_contents('./candidates/'.$k),true);
	$metadata['batch']='11:30';
	file_put_contents('./candidates/'.$k,json_encode($metadata));
	}
}
?>