<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;


class CbrService
{
    public function getRate(\DateTime $date){
        $params = [
            'VAL_NM_RQ'=>'R01235',
            'date_req1'=>$date->format('d/m/Y'),
            'date_req2'=>$date->format('d/m/Y')
        ];

        $url = 'http://www.cbr.ru/scripts/XML_dynamic.asp/?' . http_build_query($params);
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