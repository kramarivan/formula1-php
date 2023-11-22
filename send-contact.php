<!DOCTYPE html>
<html>
	<head>
		
	<meta charset="UTF-8">
    <meta name="description" content="Formula 1 - Latest news, results, drivers, and teams.">
    <meta name="keywords" content="Formula 1, F1, races, drivers, teams">
    <meta name="author" content="Ivan Kramar">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="f1ico.png" type="image/x-icon"/>
    <title>Contact</title>
	</head>
<body>
	<header>
		<div class="hero-image" style="height: 200px;"></div>
		<nav>
			<ul>
			  <li><a href="index.html">Home</a></li>
			  <li><a href="news.html">News</a></li>
			  <li><a href="contact.html">Contact</a></li>
			  <li><a href="about-us.html">About</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<h1>Contact Form</h1>
		<div id="contact">
		<iframe src="http://maps.google.com/maps?q=45.772366, 15.944950&z=16&output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
			<?php
				print '<p style="text-align:center; padding: 10px; background-color: #d7d6d6;border-radius: 5px;">We recieved your question. We will answer within 24 hours.</p>';
				$EmailHeaders  = "MIME-Version: 1.0\r\n";
				$EmailHeaders .= "Content-type: text/html; charset=utf-8\r\n";
				$EmailHeaders .= "From: <ivankramar10@gmail.com>\r\n";
				$EmailHeaders .= "Reply-To:<ivankramar55@gmail.com>\r\n";
				$EmailHeaders .= "X-Mailer: PHP/".phpversion();
				$EmailSubject = 'Contact Form';
				$EmailBody  = '
				<html>
				<head>
				   <title>'.$EmailSubject.'</title>
				   <style>
					body {
					  background-color: #ffffff;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 16px;
						padding: 0px;
						margin: 0px auto;
						width: 500px;
						color: #000000;
					}
					p {
						font-size: 14px;
					}
					a {
						color: #00bad6;
						text-decoration: underline;
						font-size: 14px;
					}
					
				   </style>
				   </head>
				<body>
					<p>First name: ' . $_POST['firstname'] . '</p>
					<p>Last name: ' . $_POST['lastname'] . '</p>
					<p>E-mail: <a href="mailto:' . $_POST['email'] . '">' . $_POST['email'] . '</a></p>
					<p>Country: ' . $_POST['country'] . '</p>
					<p>Subject: ' . $_POST['subject'] . '</p>
				</body>
				</html>';
				print '<p>First name: ' . $_POST['firstname'] . '</p>
				<p>Last name: ' . $_POST['lastname'] . '</p>
				<p>E-mail: ' . $_POST['email'] . '</p>
				<p>Country: ' . $_POST['country'] . '</p>
				<p>Subject: ' . $_POST['subject'] . '</p>';
				mail($_POST['email'], $EmailSubject, $EmailBody, $EmailHeaders);
			?>
		</div>
	</main>
	<footer>
		<p>Copyright &copy; 2023 Ivan Kramar. <a href="https://github.com/kramarivan" target="_blank"><img src="img/GitHub-Mark-Light-32px.png" title="Github" alt="Github"></a></p>
	</footer>
</body>
</html>
