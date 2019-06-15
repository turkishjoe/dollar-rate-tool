<?php
/**
 * TODO:
 *
 */

namespace App\Service\Http;

use App\Exception\ClientException;

/**
 * TODO:
 *
 * Class Client
 *
 * @package App\Service\Http
 */
class Client
{
    /**
     * TODO:
     *
     * @param string $url
     *
     * @return mixed
     */
    public function makeRequest(string $url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if($info['http_code'] != 200)
        {
            throw new ClientException("Bad http code");
        }
        curl_close($ch);

        return $result;
    }
}