<?php 
function GetIP(){
    if(getenv("HTTP_CLIENT_IP")) {
         $ip = getenv("HTTP_CLIENT_IP");
     } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
         $ip = getenv("HTTP_X_FORWARDED_FOR");
         if (strstr($ip, ',')) {
             $tmp = explode (',', $ip);
             $ip = trim($tmp[0]);
         }
     } else {
     $ip = getenv("REMOTE_ADDR");
     }
    return $ip;
}
$ip_adresi = GetIP();


require_once "ayar.php";
require_once "tasarim.php";
if (empty($ip_adresi)) {
echo "ip adresiniz al�namad�.";
}else{
@session_start();
$_SESSION['mesaj'] = $ip_adresi;
//session_destroy();
}

?>