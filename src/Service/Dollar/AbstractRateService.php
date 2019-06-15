<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;


use App\Service\Http\Client;

/**
 * Базовый класс для получения курса доллара
 *
 * Class AbstractRateService
 *
 * @package App\Service\Dollar
 */
abstract class AbstractRateService
{
    /**
     * Класс клиента
     *
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRate(\DateTime $date){
        $url = $this->prepareRequest($date);
        $result = $this->client->makeRequest($url);

        return $this->processData($result);
    }

    /**
     * Подготавливает данные для запроса. В нашем случае достаточно url,
     * при усложнении логики можно сделать объект Request и возвращать его
     *
     * @return string
     */
    abstract protected function prepareRequest(\DateTime $date) : string ;

    /**
     * Обработка запроса
     *
     * @param string $response
     *
     * @return mixed
     */
    abstract protected function processData(string $response) : float ;
}