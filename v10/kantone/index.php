<?php
$url="http://localhost/php_modul/v10/kantone/resolver.php?service=kantone&methode=single&id=ZH";
//$url="http://localhost/php_modul/v10/kantone/resolver.php?service=kantone&methode=list&sort=name";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
$body = curl_exec($ch);
curl_close($ch);
 
// Via json
$json = json_decode($body);
?>
