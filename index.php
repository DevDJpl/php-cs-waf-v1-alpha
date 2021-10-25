<?
if(!isset($_COOKIE['waf-redict'])&&$_COOKIE['waf-redict']=="false"){
	include_once("waf/index.php");
	setcookie('waf-redict', 'false');
	$_COOKIE['waf-redict'] = "false";
}else if($_COOKIE['waf-redict']=="true"){
	include_once("include/index.html");
}else{
	include_once("waf/index.php");
}

?>