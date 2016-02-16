<?php
/*
 * Bu sayfa önderilen herhangi iki notanın arası mesafeyi ölçer ve google dan kalan km ve dakikayı 
 * alarak geri döndürür. Javascript apisi ile olna bi işlemdir.
 */
function GetDrivingDistance($lat1, $lat2, $long1, $long2, $mapsApi) {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&key=" . $mapsApi;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    return array('distance' => $dist, 'time' => $time);
}

if ($_POST) {
    $sonuc = array();
    $coordinates1['lat'] = $_POST["lat1"];
    $coordinates2['lat'] = $_POST["lat2"];
    $coordinates1['long'] = $_POST["long1"];
    $coordinates2['long'] = $_POST["long2"];
    $mapsApi = $_POST["mapsAps"];
    $dist = GetDrivingDistance($coordinates1['lat'], $coordinates2['lat'], $coordinates1['long'], $coordinates2['long'], $mapsApi);
    $sonuc["Km"] = $dist['distance'];
    $sonuc["Times"] = $dist['time'];
    echo json_encode($sonuc);
} else {
    die("Hacking???");
}
?>