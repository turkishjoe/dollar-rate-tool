<?php
/**
 * TODO:
 *
 */

namespace App\Service\Http;


class Client
{
    public function makeRequest($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if($info['http_code'] != 200)
        {

        }
        curl_close($ch);
    }
}