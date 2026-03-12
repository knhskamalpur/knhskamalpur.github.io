<?php
$title=isset($title) ? $title : "";
echo '<!doctype html>
<html lang="en">
  <head>
    <title>'.$title.'</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="prefetch" href="./tick.png">
<link rel="prefetch" href="./holder.png">
	<style>
        *{
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently*/
         }
	.red_box{border:red solid 1px;}
	.xbtn-success {
		color: #000000;
		background-color: #ffffff21;
		border-color: #000000;
	}
	label > input{
		display: none;
	}
	
	label > input + b{
		padding: 3px 3px 3px 35px;
		border: 0px solid red;
		white-space: nowrap;
		background: url(\'./holder.png\') no-repeat;
		background-size: auto 80%;
		background-position: left center; 
	}
	label > input:checked + b{
		background: url(\'./tick.png\') no-repeat;
		background-size: auto 80%;
		background-position: left center; 
	}
	#row_x,#flag{
		display:none;
	}
	@media print {
		.card{
			background: white !important;
		}
		.delrow{
			page-break-inside: avoid;
			font-size: 11px;
		}
	  .modal {
		position: static !important;
	  }
	  #footer{
		  display: none !important;
	  }
	  .modal-backdrop{
		  background: transparent !important;
	  }
		#row_x{
			display:block;
		}
		#flag{
			display:inline-block;
		}
	}
	</style>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./bootstrap_4_0_0_2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap_4_0_0_2/css/glyphicon.css">
    <link rel="stylesheet" href="./style.css">
    <script src="./jquery-3.2.1.min.js"></script>
    <script src="./popper.min.js"></script>
    <script src="./bootstrap_4_0_0_2/js/bootstrap.min.js"></script>
  </head>';
?>