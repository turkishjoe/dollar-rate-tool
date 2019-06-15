<?php
/**
 * TODO:
 *
 */

namespace App\Service\Dollar;


use App\Exception\ServiceException;
use App\Exception\SystemException;
use Psr\Container\ContainerInterface;

class RateLocator
{
    /**
     * https://cash.rbc.ru/cash/json/converter_currency_rate
     */
    const TYPE_CBR = 0;

    /**
     * https://www.cbr.ru/development/SXML/
     */
    const TYPE_CASH_CBR = 1;

    /**
     * Контейнер
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Маппинг число=>объект из контейнера
     * Число используется в консольном приложении. При измении
     * интерфейса нужно будет иметь допольнительный маппинг
     *
     * @var array
     */
    private $mapping
        = [
            self::TYPE_CBR => CbrService::class,
            self::TYPE_CASH_CBR => RbcService::class,
        ];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Метод для получения объекта из контейнера по serviceId
     *
     * @param integer $serviceId
     *
     * @return AbstractRateService
     */
    public function get(int $serviceId): AbstractRateService
    {
        if (!isset($this->mapping[$serviceId])
            || !$this->container->has($this->mapping[$serviceId])
        ) {
            throw new ServiceException("Service not exists");
        }


        $service = $this->container->get($this->mapping[$serviceId]);

        if (!$service instanceof AbstractRateService) {
            throw new SystemException("Bad rate service mapping configure");
        }

        return $service;
    }
}