<?php
include 'check_login.php';
$title="Admin Panel";
include 'header.php';
if(isset($_POST['roll'])){
	if(file_exists('../candidates/'.$_POST['roll'].'.submit')){
		$meta=json_decode(file_get_contents('../candidates/'.$_POST['roll'].'.submit'),true);
		var_dump($meta);
	}
	else{
		echo '<br><br><br><br><center><h2>No Result Found.</h2></center>';
	}
}
include 'footer.php';
?>