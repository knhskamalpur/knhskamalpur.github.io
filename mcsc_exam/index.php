<!doctype HTML>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Examination</title>
		<style>
			*{
				margin:0;
				border:0;
                                font-family: "Lucida Console", Monaco, monospace,arial;
			}
			p {
				text-align: center;
				font-size: 45px;
				margin-top: 50px;
			}
			.footer {
				background: rgba(0,0,0,0.3);
				color: white;
				position: fixed;
				display: block;
				width: 100%;
				left:0;
				bottom:0;
				text-align: center;
				padding: 10px;
				margin-bottom: 0;
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
                                border: 1px dashed red;
				background: #87ceeb;
				min-height: 100vh;
				outline: thick ridge orangered;
				outline-offset: -20px;
				margin: 0px;
			}
a{color: orangered;font: bold;text-decoration:none;}
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
    var countDownDate = new Date("May 16, 2018 10:10:25").getTime();
    var now = new Date().getTime();

    var x = setInterval(function() {
        now = now + 1000;
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("demo").innerHTML = days + "Days " + hours + "Hours " +
            minutes + "Minutes " + seconds + "Second ";
        if (distance < 0) {
            clearInterval(x);
            // document.getElementById("demo").innerHTML = "EXPIRED";
			window.location="http://www.mahamayacsc.in/online-exam/result.php";
        }
    }, 1000);
    </script>
</html>