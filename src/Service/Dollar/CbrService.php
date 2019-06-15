<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;

use App\Exception\ServiceException;

/**
 * Сервис, который получает курс доллара из сервиса
 * https://www.cbr.ru/development/SXML/
 *
 * Class CbrService
 *
 * @package App\Service\Dollar
 */
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
            'VAL_NM_RQ' => 'R01235',
            'date_req1' => $date->format('d/m/Y'),
            'date_req2' => $date->format('d/m/Y'),
        ];

        return 'http://www.cbr.ru/scripts/XML_dynamic.asp/?'
            .http_build_query($params);
    }

    /**
     * Обработка запроса
     *
     * @param string $response
     *
     * @return float
     */
    protected function processData(string $response): float
    {
        $data = simplexml_load_string($response);

        if (isset($data->Record->Value)) {
            return $this->toFloat($data->Record->Value);
        }

        throw new ServiceException("Bad service response body");
    }

    /**
     * TODO:
     *
     * @param $number
     *
     * @return float
     */
    protected function toFloat($number)
    {
        return floatval(str_replace(',', '.', str_replace('.', '', $number)));
    }
}