<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;


use App\Service\Http\Client;

abstract class AbstractRateService
{
    /**
     * TODO:
     *
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRate(\DateTime $date){
        $url = $this->getRate($date);
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
     * TODO:
     *
     * @param $response
     *
     * @return mixed
     */
    abstract protected function processData($response);
}