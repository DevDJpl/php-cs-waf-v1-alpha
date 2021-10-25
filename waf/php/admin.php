<?php
$cfg = $config;
$api = $cfg['api'];
$global = $cfg['global'];
$location = $cfg['location'];
//$website = $cfg['page'];
$select = $cfg['select'];
$insert = $cfg['insert'];
//$update = $cfg['update'];
$delete = $cfg['delete'];
if($cfg['lang']['enabled']==true){
	if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		$acceptLang = ['pl', 'en', 'us'];
		$lang = in_array($lang, $acceptLang) ? $lang : 'en';
		require_once("/waf/".$location['lang'].$cfg['lang']['prefix']."{$lang}".$cfg['lang']['surfix'].$global['surfix']['php']);
		//var_dump($lang);
	}else{
		if(!isset($lang)){
			$lang = 'en';
			require_once("/waf/".$location['lang'].$cfg['lang']['prefix']."{$lang}".$cfg['lang']['surfix'].$global['surfix']['php']);
		}
	}
}else{
	if(!isset($lang)){
		$lang = 'en';
		require_once("/waf/".$location['lang'].$cfg['lang']['prefix']."{$lang}".$cfg['lang']['surfix'].$global['surfix']['php']);
	}
}

$db = $cfg['database'];
$host = $db['host'];
$username = $db['user'];
$password = $db['password'];
$database = $db['databaseName'];
//$_SESSION['sid'] = session_id();

if(!isset($pdo)){
	try {
		$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
		// set the PDO error mode to exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		$message = json_encode(array(
			'message'=> [
				'type'=> 'error',
				'class'=> 'text-error',
				'header'=> $lang['error']['header']['2'],
				'content'=> $lang['error']['database'],
			]
		));
		$error = '<b>'.$e->getMessage().'</b>';
	}
}

?>
