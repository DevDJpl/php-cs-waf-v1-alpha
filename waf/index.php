<?php

require_once("../waf/config/config.php");
require_once("../waf/php/admin.php");

if(isset($pdo)){
	function post($url, $postVars = array()){
		$content = http_build_query($postVars);
		$options = array(
			'http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $content
				)
		);
		$streamContext = stream_context_create($options);
		$result = file_get_contents($url, false, $streamContext);
		if($result===false){
			$error = error_get_last();
			throw new Exception('POST request failed: ' . $error['message']);
		}
		return $result;
	}

	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	if(isset($_SERVER['SERVER_NAME'])&&isset($_SERVER['HTTP_HOST'])){
		if($_SERVER['SERVER_NAME']==$_SERVER['HTTP_HOST']){
			$site = $_SERVER['SERVER_NAME'];
			$result = post('http://'.$site.'/waf/php/check.php', array('domain'=> $site, 'client_ip'=> $ip, 'lang'=> $lang['prefix']));
			echo($result);
		}
	}else if(isset($_SERVER['SERVER_ADDR'])&&isset($_SERVER['REMOTE_ADDR'])){
		if($_SERVER['SERVER_ADDR']==$_SERVER['REMOTE_ADDR']){
			$site = $_SERVER['SERVER_ADDR'];
			$result = post('http://'.$site.'/waf/php/check.php', array('ip'=> $site, 'client_ip'=> $ip, 'lang'=> $lang['prefix']));
			echo($result);
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<!-- Title -->
		<title><?php echo($lang['site']['title']); ?></title>

	<!-- Icon -->
		<link rel="shortcut icon" type="image/x-icon" href="../waf/images/favicon.png" />

	<!-- Meta -->
		<meta name="keywords" content="Cyber Security, DevDJ, Security, Protection, WAF, Anty DDoS, Anty DoS, Anty DDoS Protection, Firewall, Blocking Atack, Anty Proxy, Anty VPN, Anty Cookies, DJ Kondzio, DJ, Kondzio" />
		<meta name="description" content="WebSite Protection" />
		<meta name="author" content="DevDJ" />
		<meta name="copyrights" content="Cyber Security" />
		<meta name="revised" content="11.10.2019" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="googlebot" content="all" />
		<meta name="robots" content="noindex, nofollow" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="reply-to" content="contact@DevDJ.pl" />
		<meta charset="UTF-8" />

	<!-- OG Tags -->
		<meta property="og:site_name" content="Cyber Security">
		<meta property="og:title" content="<?php echo($lang['site']['title']); ?>">
		<meta property="og:description" content="WebSite Protection">
		<meta property="og:url" content="https://DevDJ.pl/">
		<meta property="og:locale" content="<?php echo($lang['site']['locale']); ?>">
		<meta property="og:type" content="website">
		<meta property="og:image" content="https://DevDJ.pl/">
		<meta property="og:image:width" content="800">
		<meta property="og:image:height" content="1200">
		<!-- additional media -->

		<!-- Twitter summary card meta tags -->
		<meta name="twitter:title" content="<?php echo($lang['site']['title']); ?>">
		<meta name="twitter:description" content="WebSite Protection">
		<meta name="twitter:url" value="https://DevDJ.pl/">
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:image" content="https://DevDJ.pl/">

	<!-- Style CSS -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" />
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../waf/css/style.css" />
</head>
<body class="devdj veryfication-bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<span class="loading">
					<img class="logo" src="../waf/images/app-logo.png">
					<h1 class="message noscript">
						<span class="text-message-info"><?php echo($lang['message']['1']); ?></span><br>
						<small><?php echo($lang['message']['2']); ?></small>
					</h1>
					<noscript>
						<h1 class="message text-error">
							<strong><?php echo($lang['message']['javascript']); ?></strong>
						</h1>
					</noscript>
				</span>
			</div>
			<div class="footer">
				<div class="second-footer">
					<p class="copyright">&copy <script>document.write(new Date().getFullYear())</script>  <a href="//DevDJ.pl" target="_blank" name="DevDJ" title="DevDJ" rel="DevDJ" noopener="DevDJ">Cyber Security</a> - All Rights Reserved</p>
				</div>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/javascript">
	$(function(){
		'use strict';
		<?php
		if(isset($pdo)){
			$sql = $pdo->prepare($select['messages']);
			$sql->execute(['hostname'=> $_SERVER['SERVER_NAME']]);
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			if($sql->rowCount()>0){
				echo("var message = jQuery.parseJSON('".$row['message']."');");
				echo("var message = message.message;");
				echo('var prefix = "Cyber Security | ";');
				$sql = $pdo->prepare($delete['messages']);
				$sql->execute(['id'=> 1]);//,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $row['message']]);
			}
		}else{
			echo("var message = jQuery.parseJSON('".$message."');");
			echo("var message = message.message;");
			echo('var prefix = "Cyber Security | ";');
		}
		?>
		if(message.type==="error"){
			var logo = setInterval(()=>{
				$('.logo').fadeOut('slow').fadeIn('slow');
			}, 1100);
			var check = setTimeout(()=>{
				if(message.content!==""){
					$('title').html(prefix+message.header);
					$('.text-message-info').html(message.header).removeClass('text-message-info').addClass(message.class);
					$('.message').find($('small')).html(<?php if(isset($error)){echo('message.content+"<br />'.$error.'"');}else{echo('message.content');} ?>).addClass(message.class);
				}else{
					$('title').html(prefix+message.header);
					$('.text-message-info').html(message.header).removeClass('text-message-info').addClass(message.class);
					$('.message').find($('small')).html(message.content);
				}
			}, Math['floor'](Math['random']()*(+5000-+1000))+ +1000);
		}else if(message.type==="success"){
			var logo = setInterval(()=>{
				$('.logo').fadeOut('slow').fadeIn('slow');
			}, 1100);
			var check = setTimeout(()=>{
				if(message.content!==""){
					$('title').html(prefix+message.header);
					$('.text-message-info').html(message.header).removeClass('text-message-info').addClass(message.class);
					$('.message').find($('small')).html(message.content);
				}else{
					$('title').html(prefix+message.header);
					$('.text-message-info').html(message.header).removeClass('text-message-info').addClass(message.class);
					$('.message').find($('small')).html(message.content);
				}
			}, Math['floor'](Math['random']()*(+5000-+1000))+ +1000);
		}
	});
	</script>
</body>
</html>
