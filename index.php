<?php 

	/*
		SQLInjection Vuln Checker
		Coded by João Artur (K3N1)
		Designed by ZanutSec

		http://www.youtube.com/c/KeniGamer
		http://www.github.com/JoaoArtur

		https://www.youtube.com/user/hackzanut
		https://twitter.com/zanutsec
	*/
	error_reporting(0);

	if (!isset($_POST['started'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>SQLInjection Vuln Checker v1</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<meta charset="utf-8">
</head>
<body>
	<center>
		<h1>SQLInjection Vuln Checker</h1>
		<div class="content-tool">
			<form method="post">
				<textarea rows="5" name="websites" placeholder="Put your websites list" ></textarea>
				<br />
				<input type="hidden" name="started" value="started">
				<input type="submit" value="Start check"><br>
			</form>
		</div>
		<p>&copy; SQL Injection Vuln Checker created by K3N1 and zanutsec</p>
	</center>

</body>
</html>
<?php
}
 else {
?>
	<html>
	<head>
		<title>SQLInjection Vuln Checker</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body><center>
			<h1>SQLInjection Vuln Checker</h1>
			<h2>Coded by K3N1</h2>
			<h3>Designed by ZanutSec</h3>
			<br />
			<?php 
				$websites = explode("\n",str_replace("\n\n","\n",$_POST['websites']));
				foreach ($websites as $website) {
					//Get the id
					$siteid = explode("=",$website);
					$fullwebsite = $siteid[0]."='".$siteid[1];
					$gethead = get_headers($website);
					if (eregi('200', $gethead[0])) {
						$context = file_get_contents($fullwebsite);
						$fullwebsite2 = str_replace("'", "%27", $fullwebsite);
						$errs = array('mysql_','mysql','error','syntax','mysql_num_rows');

						if (strstr($context, 'mysql') or strstr($context, 'MYSQL') or strstr($context, 'ERROR') or strstr($context, 'SYNTAX') or strstr($context,'You have an error in your SQL syntax') or strstr($context,'unable to select * from')) {
							echo "<p class='vuln'>[+] Site vulnerable: <a target='_blank' class='vulnn' href='".$fullwebsite2."'>".$fullwebsite."</a></p>";
						} else {
							echo "<p class='notvuln'>[-] Site not vulnerable: <a target='_blank' class='notvulnn' href='".$fullwebsite2."'>".$fullwebsite."</a></p>";
						}

					} else {
							echo "<p class='notvuln'>[-] Incorrect path or forbidden access in: <a target='_blank' class='notvulnn' href='".$fullwebsite2."'>".$fullwebsite."</a></p>";
					}
				}
				echo "<h3 class='vuln'>Check success!</h3>";
			?>
		</center>
	</body>
	</html>
<?php
}
?>