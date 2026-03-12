<?php
include 'func.php';
$title="END";
include 'header.php';
echo '<br><br><br><center><h2>Trial Examination Ended.</h2><br><b>Back To <a href="dash.php?d='.base64_encode(json_encode($_GET)).'">Home</a>.</b></center>';
include 'footer.php';
?>