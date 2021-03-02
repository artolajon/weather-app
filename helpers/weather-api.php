<?php

function get_current_weather($city){
    $query = "weather?q=".$city;

    return call_api($query);
}
function get_weather_forecast($city){
    $query = "forecast?q=".$city;

    return call_api($query);
}



function call_api($query){
    $url = $_ENV["API_URL"].$query."&appid=".$_ENV["API_KEY"];
    $curl = curl_init();
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
 }

 const ICON_TRANSLATION= [
    "01" => "sun",
    "02" => "cloud-sun",
    "03" => "cloud",
    "04" => "cloud",
    "09" => "cloud-showers-heavy",
    "10" => "cloud-sun-rain",
    "11" => "bolt",
    "13" => "snowflake",
    "50" => "smog",
];
 function translate_icon_code($code){
    $num = substr($code, 0, 2);
    return ICON_TRANSLATION[$num];
 }



?>