<?php
$config = array();

// Config Database
$config['database'] = array(

	'host' => '', //Database IP
	'user' => '', //Database User
	'password' => '', //Database Password
	'databaseName' => '' //Database Name

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
		'pages' => '.page', //Name extension file
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
	'enabled' => true, //True or False
	'prefix' => '', //Prefix of files with languages (name before language abbreviation)
	'surfix' => '', //Surfix language files (name after language abbreviation)
);

// Config Lacation
$config['location'] = array(
	'homepage' => '', //Domyślna Lokalizacja strony
	'lang' => 'include/language/', //Localization of translation files
	'template' => 'templates/', //Template location
	'include' => 'include/', //Location of attached files
	'pages' => 'pages/', //Location of pages
	'php' => 'php/' //Location of php files (connect to base, etc.)
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
