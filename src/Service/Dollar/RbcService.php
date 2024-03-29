<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;


use App\Exception\ServiceException;

/**
 * Сервис для получения данных https://cash.rbc.ru/cash/json/converter_currency_rate
 *
 * Class RbcService
 *
 * @package App\Service\Dollar
 */
class RbcService extends AbstractRateService
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
            'currency_from' => 'USD',
            'currency_to' => 'RUR',
            'source' => 'cbrf',
            'sum' => 1,
            'date' => $date->format('Y-m-d'),
        ];

        return 'https://cash.rbc.ru/cash/json/converter_currency_rate/?'
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
        $data = json_decode($response, true);
        if (!isset($data['status']) || $data['status'] !== 200
            || !isset($data['data']['sum_result'])
        ) {
            throw new ServiceException("Bad service response body");
        }

        return $data['data']['sum_result'];
    }
}