<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_TIME, "in_IN.utf8");
date_default_timezone_set('Asia/Kolkata');

$title=isset($title) ? $title : "$site_name";
$_comn_h="";

echo('
<!doctype html>
<html lang="en">
<head>
		<title>'.$title.'</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../bootstrap_4_0_0_2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap_4_0_0_2/css/glyphicon.css">
    <link rel="stylesheet" href="../style.css">
		<link rel="stylesheet" type="text/css" href="styles.css?'.filemtime('styles.css').'"/>
		<link rel="shortcut icon" href="images/ic.png" type="image/png"/>
		<link rel="icon" href="images/ic.png" type="image/png"/>
		
		
		<script src="../jquery-3.2.1.slim.min.js"></script>
		<script src="../popper.min.js"></script>
		<script src="../bootstrap_4_0_0_2/js/bootstrap.min.js"></script>
		
		'.$_comn_h.'
</head>');

echo('<body>
		
	');

?>