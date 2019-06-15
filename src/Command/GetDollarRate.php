<?php
/**
 * TODO:
 *
 */

namespace App\Command;


use App\Service\Dollar\CbrService;
use App\Service\Dollar\RateService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * TODO:
 *
 * Class GetDollarRate
 *
 * @package App\Command
 */
class GetDollarRate extends Command
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
     * TODO:
     *
     * @var RateService
     */
    private $rateService;


    public function __construct(?string $name = null, CbrService $rateService)
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
            ', self::TYPE_CBR)
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');
        $dateString = $input->getArgument('datetime') ;
        $date = new \DateTime($dateString);

        var_dump($this->rateService->getRate($date));
       // $output->writeln($this->rateService->getRate());
    }
}