<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
if(isset($_POST['domain'])||isset($_POST['ip'])){
	require_once("../config/config.php");
	require_once("admin.php");
	require_once("helper.php");

	/* Lang Include For Checking Messages */
	if(isset($_POST['lang'])){
		$lang = $_POST['lang'];
		require_once("/waf/".$location['lang'].$cfg['lang']['prefix'].$lang.$cfg['lang']['surfix'].$global['surfix']['php']);
	}
	
	/* System Checker */
	$site = (isset($_POST['domain']) ? $_POST['domain'] : $_POST['ip']);
	$sql = $pdo->prepare($select['site_DNS']);
	$sql->execute(['hostname'=> $site]);
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($sql->rowCount()===0){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'error',
				'class'=> 'text-error',
				'header'=> $lang['error']['header']['2'],
				'content'=> $lang['error']['system'],
			]
		));
		$sql = $pdo->prepare($insert['messages']);
		$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
		echo $site;
		die();
	}
	
	/* IP Checker */
	$ip = $_POST['client_ip'];
	//$client_ip = json_decode(file_get_contents("https://api.ipify.org/?format=json"), true);
	$client_ip = json_decode(file_get_contents("http://ip-api.com/json/$ip"), true);
	if($ip!==$client_ip['query']){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'error',
				'class'=> 'text-error',
				'header'=> $lang['error']['header']['1'],
				'content'=> $lang['error']['ip'],
			]
		));
		$sql = $pdo->prepare($insert['messages']);
		$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
		die();
	}

	/* Location Checker */
	$location = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip"));
	if(isset($location)&&in_array($locale, $countries)){
		$country = $location["geoplugin_countryName"];
		$city = $location["geoplugin_city"];
		$langPrefix = strtolower($location["geoplugin_countryCode"]);
		if($locale!==$langPrefix){
			$message = json_encode(array(
				'message'=> [
					'type'=> 'error',
					'class'=> 'text-error',
					'header'=> $lang['error']['header']['1'],
					'content'=> $lang['error']['location'],
				]
			));
			$sql = $pdo->prepare($insert['messages']);
			$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
            die();
		}
	}
	
	/* Proxy Checker */
	$result = json_decode(file_get_contents(sprintf('http://proxycheck.io/v2/%s?key=%s&risk=1', $ip, $api['proxy'])), true);
	if($result!==null){
        if(isset($result['proxy'])&&$result['proxy']=="yes"){
			$message = json_encode(array(
				'message'=> [
					'type'=> 'error',
					'class'=> 'text-error',
					'header'=> $lang['error']['header']['1'],
					'content'=> $lang['error']['proxy'],
				]
			));
			$sql = $pdo->prepare($insert['messages']);
			$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
            die();            
        }
	}

	/* VPN Checker */
    $strictness = 1;
    $result = json_decode(file_get_contents(sprintf('https://ipqualityscore.com/api/json/ip/%s/%s?strictness=%s', $api['vpn'], $ip, $strictness)), true);
    if($result!==null){
		if(isset($result['vpn'])&&$result['vpn']==true){
			$message = json_encode(array(
				'message'=> [
					'type'=> 'error',
					'class'=> 'text-error',
					'header'=> $lang['error']['header']['1'],
					'content'=> $lang['error']['vpn'],
				]
			));
			$sql = $pdo->prepare($insert['messages']);
			$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
            die();            
        }
	}
	
	/* BlackList Countries Checker */
	$sql = $pdo->prepare($select['blackList_Countries']);
	$sql->execute(['country'=> $locale]);
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($sql->rowCount()>0){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'error',
				'class'=> 'text-error',
				'header'=> $lang['error']['header']['1'],
				'content'=> $lang['error']['blackList']['country'],
			]
		));
		$sql = $pdo->prepare($insert['messages']);
		$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
		die();
	}
	
	/* BlackList Clients Checker */
	$sql = $pdo->prepare($select['blackList_Clients']);
	$sql->execute(['ip'=> $ip]);
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($sql->rowCount()>0){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'error',
				'class'=> 'text-error',
				'header'=> $lang['error']['header']['1'],
				'content'=> $lang['error']['blackList']['client'].$row['reason'],
			]
		));
		$sql = $pdo->prepare($insert['messages']);
		$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
		die();
	}

	/* Connection Checker */
	if(isset($connection)){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'error',
				'class'=> 'text-error',
				'header'=> $lang['error']['header']['1'],
				'content'=> $lang['error']['connection']['veryfication'],
			]
		));
		$sql = $pdo->prepare($insert['messages']);
		$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
		//die();
	}
	
	/* DNS Checker */
	if(isset($_POST['domain'])){
		$site = $_POST['domain'];
		$hostname = $site;
		$ip = gethostbyname($site);
	}
	if(isset($_POST['ip'])){
		$ip = $_POST['ip'];
		$hostname = gethostbyaddr($ip);
		$ip = $ip;
	}
	
	/* BlackList WebSites Checker */
	$sql = $pdo->prepare($select['blackList_Sites']);
	$sql->execute(['hostname'=> $hostname, 'ip'=> $ip]);
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($sql->rowCount()>0){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'error',
				'class'=> 'text-error',
				'header'=> $lang['error']['header']['1'],
				'content'=> $lang['error']['blackList']['site'],
			]
		));
		$sql = $pdo->prepare($insert['messages']);
		$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
		die();
	}
	
	/* Success */
	if(!isset($message)){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'success',
				'class'=> 'text-success',
				'header'=> $lang['success'],
				'content'=> '',
			]
		));
		$sql = $pdo->prepare($insert['messages']);
		$sql->execute(['id'=> 1,'hostname'=> $_SERVER['SERVER_NAME'],'message'=> $message]);
		$_COOKIE['waf-redict'] = 'true';
		echo('<script>setTimeout(()=> {document.cookie = "waf-redict=true; path=/"; location.reload(true);}, 5500);</script>');	
	}
}

?>
