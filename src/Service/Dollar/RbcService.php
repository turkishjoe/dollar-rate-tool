<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;


class RbcService
{
    public function getRate(\DateTimeInterface $date){
        $params = [
            'currency_from'=>'USD',
            'currency_to'=>'RUR',
            'source'=>'cbrf',
            'sum'=>1,
            'date'=>$date->format('Y-m-d')
        ];

        $url = 'https://cash.rbc.ru/cash/json/converter_currency_rate/?' . http_build_query($params);
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
        return json_decode($result, true);
    }
}