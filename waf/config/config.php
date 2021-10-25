<?php
$config = array();

// Config Database
$config['database'] = array(

	'host' => 'serwer1962108.home.pl', //IP Bazy Danych
	'user' => '31072472_waf', //Login do Bazy Danych
	'password' => 'ZvSW1pxD3L2yeZ7G8', //Haslo do Bazy Danych
	'databaseName' => '31072472_waf' //Nazwa Bazy Danych

);

// API Keys
$config['api'] = array(
	'proxy' => '086h7s-0v5655-3q33v4-i16e41',
	'vpn' => '5qyo4UqDwGX8QcA6b1ZmPXWstIbSYWLN',
);

// Global Configuration
$config['global'] = array(
	'prefix' => array(
		'include' => 'include/',
		'vendor' => 'vendor/',
		'fonts' => 'fonts/',
		'img' => 'images/',
		'css' => 'css/',
		'js' => 'js/'
	),
	'surfix' => array(
		'pages' => '.page', //Naza pliku między nazwą a rozszeżeniem
		'svg' => '.svg',
		'png' => '.png',
		'jpg' => '.jpg',
		'php' => '.php',
		'html' => '.html',
		'css' => '.css',
		'js' => '.js',
		'ico' => '.ico',
		'gif' => '.gif'
	)
);

// Config Language
$config['lang'] = array(
	'enabled' => true, //Włączyć czy Wyłaczyć
	'prefix' => '', //Prefix plików z językami (nazwa przed skrótem języka)
	'surfix' => '', //Surfix plików z językami (nazwa po skrócie języka)
);

// Config Lacation
$config['location'] = array(
	'homepage' => '', //Domyślna Lokalizacja strony
	'lang' => 'include/language/', //Lokalizacja plików z tłumaczeniem
	'template' => 'templates/', //Lokalizacja szablonów
	'include' => 'include/', //Lokalizacja dołączanych plików
	'pages' => 'pages/', //Lokalizacja stron
	'php' => 'php/' //Lokalizacja plików php (Connecta do bazy itp)
);

$config['select'] = array(
	'hostname' => 'hostname',
	'ip' => 'ip',
	'country' => 'country',
	'blackList_Countries' => 'SELECT * FROM `blackList_Countries` WHERE country=:country',
	'blackList_Clients' => 'SELECT * FROM `blackList_Clients` WHERE ip=:ip',
	'blackList_Sites' => 'SELECT * FROM `blackList_Sites` WHERE hostname=:hostname AND ip=:ip',
	'messages' => 'SELECT * FROM `messages` WHERE hostname=:hostname',
	'site_DNS' => 'SELECT * FROM `site_DNS` WHERE domain=:hostname',
);

$config['insert'] = array(
	'id' => 'id',
	'hostname' => 'hostname',
	'message' => 'message',
	'messages' => 'INSERT INTO `messages` (id, hostname, message) VALUES (:id, :hostname, :message)',
);

$config['delete'] = array(
	'id' => 'id',
	'hostname' => 'hostname',
	'message' => 'message',
	'messages' => 'DELETE FROM `messages` WHERE id=:id',// AND hostname=:hostname AND message:message',//id=:id AND hostname=:hostname',
);

?>
