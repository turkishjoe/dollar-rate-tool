<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;


use App\Service\Http\Client;

class CbrService extends AbstractRateService
{
    /**
     * Подготавливает данные для запроса. В нашем случае достаточно url,
     * при усложнении логики можно сделать объект Request и возвращать его
     *
     * @return string
     */
    protected function prepareRequest(\DateTime $date): string
    {
        $params = [
            'VAL_NM_RQ'=>'R01235',
            'date_req1'=>$date->format('d/m/Y'),
            'date_req2'=>$date->format('d/m/Y')
        ];

        return 'http://www.cbr.ru/scripts/XML_dynamic.asp/?' . http_build_query($params);
    }

    /**
     * TODO:
     *
     * @param $response
     *
     * @return mixed
     */
    protected function processData($response)
    {
        $data = simplexml_load_string($response);

        return $data;
    }
}