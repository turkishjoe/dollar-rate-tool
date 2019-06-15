<?php
/**
 * TODO:
 *
 */

namespace App\Command;

use App\Exception\ServiceException;
use App\Exception\SystemException;
use App\Service\Dollar\RateLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Комманда для получения курса доллара
 *
 * Class GetDollarRate
 *
 * @package App\Command
 */
class GetDollarRate extends Command
{
    /**
     * Сервис
     *
     * @var RateLocator
     */
    private $rateService;


    public function __construct(?string $name = null, RateLocator $rateService)
    {
        parent::__construct($name);

        $this->rateService = $rateService;
    }

    protected function configure()
    {
        $this
            ->setName('app:add_provider')
            ->addArgument('datetime', InputArgument::OPTIONAL, 'Date of rate', 'now')
            ->addArgument('type', InputArgument::OPTIONAL, 'Type of service
            0 - https://cash.rbc.ru/cash/json/converter_currency_rate
            1 - https://www.cbr.ru/development/SXML/
            ', RateLocator::TYPE_CBR)
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');
        $dateString = $input->getArgument('datetime') ;
        $date = new \DateTime($dateString);

        try{
           $result = $this->rateService->get($type)->getRate($date);
           $output->writeln(sprintf('Rate is %s', $result));
        }catch (ServiceException $exception){
           $output->writeln('error');
           $output->writeln($exception->getMessage());
        }catch (SystemException $exception){
            //Куда-нибудь логировать
        }
    }
}