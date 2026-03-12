<!doctype HTML>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Examination</title>
		<style>
			*{
				margin:0;
				border:0;
			}
			p {
				text-align: center;
				font-size: 45px;
				margin-top: 50px;
			}
			.footer {
				position: fixed;
				display: block;
				width: 100%;
				bottom:0;
				text-align: center;
				padding: 10px;
				margin-bottom: 10px;
			}
			h {
				border: 2px solid red;
			}
			h1 {
				border: 4px dotted blue;
			}
			.double {
				border: double;
			}
			body {
				background: #0099cc;
				border: double;
				min-height: 96vh;
				margin: 10px;
			}

			body {
				background: #87ceeb;
				min-height: 100vh;
				outline: thick ridge orange;
				outline-offset: -10px;
				margin:0;
			}
			.heading {
				text-align: center;
				font-size: 30px;
				max-width: 70vw;
				margin-left: auto;
				margin-right: auto;
				margin-top: 15vh;
			}
			#demo{
				margin-bottom: 30px;
				font-size: 40px;
			}
		</style>
	</head>
	<body>
		<div class="heading">মহামায়া কমন সার্ভিস সেন্টার আয়োজিত অনলাইন মক টেস্ট এর ফলাফল ১৬ই মে ২০১৮, সকাল ১০:০০:০০ এ দেখা যাবে এখান থেকে।</div>
		<div id="demo" class="heading">DD:HH:MM:SS</div>
		<div class="footer">Developed By <a href="http://sorisoft.ml/">SoRi Soft</a></div>
	</body>
    <script>
    // Set the date we're counting down to
    // 1. JavaScript
    // var countDownDate = new Date("May 16, 2018 10:10:25").getTime();
    // 2. PHP
    var countDownDate = <?php echo strtotime('may 16, 2018 10:10:25') ?> * 1000;
    var now = <?php echo time() ?> * 1000;

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        // 1. JavaScript
        // var now = new Date().getTime();
        // 2. PHP
        now = now + 1000;

        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = days + "Days " + hours + "Hours " +
            minutes + "Minutes " + seconds + "Second ";

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            // document.getElementById("demo").innerHTML = "EXPIRED";
			window.location="http://www.mahamayacsc.in/online-exam/result.php";
        }
    }, 1000);
    </script>
</html>