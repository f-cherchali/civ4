<?php 
    function generate_token($number=8){
        $token = bin2hex(random_bytes($number));
        return $token;
    }
    function httpGet($url){
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //  curl_setopt($ch,CURLOPT_HEADER, false); 
        $output=curl_exec($ch);
        curl_close($ch);
        return $output;
    }
?>