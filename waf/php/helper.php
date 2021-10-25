<?php

if(isset($_POST['client_ip'])){
	$ip = $_POST['client_ip'];
   // $locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://ipinfo.io/{$ip}/geo");
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER , true);
    $output = curl_exec($curl);
    curl_close($curl);
    $locale = json_decode($output, true);
    $countries = array( 'ae', 'af', 'al', 'ar', 'at', 'au', 'ba', 'bb', 'bd', 'be', 'bg', 'bo', 'br', 'by', 'ca', 'ch', 'cn', 'co', 'cy', 'cz', 'de', 'dk', 'dz', 'ec', 'ee', 'eg', 'es', 'fi', 'fr', 'gb', 'gr', 'hr', 'hu', 'id', 'ie', 'il', 'in', 'iq', 'ir', 'it', 'jp', 'kn', 'kp', 'lr', 'lt', 'lv', 'mc', 'md', 'mx', 'nl', 'no', 'nz', 'ph', 'pk', 'pl', 'pt', 'py', 'ro', 'ru', 'sa', 'se', 'si', 'sk', 'tn', 'ua', 'us', 'vn');;
    $locale = in_array(strtolower($locale['country']), $countries) ? strtolower($locale['country']) : 'en';
}

?>