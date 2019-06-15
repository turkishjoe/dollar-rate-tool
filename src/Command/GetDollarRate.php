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
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @var ValidatorInterface
     */
    private $validator;


    public function __construct(?string $name = null, RateLocator $rateService, ValidatorInterface $validator)
    {
        parent::__construct($name);

        $this->rateService = $rateService;
        $this->validator = $validator;
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
        $type = (int)$input->getArgument('type');
        $dateString = $input->getArgument('datetime') ;
        $date = new \DateTime($dateString);

        $errors = $this->validate($date, $type);
        if(count($errors) !== 0){
            foreach ($errors as $error){
                $output->writeln($error->getMessage());
            }
        }else {
            try {
                $result = $this->rateService->get($type)->getRate($date);
                $output->writeln(sprintf('Rate is %s', $result));
            } catch (ServiceException $exception) {
                $output->writeln('error');
                $output->writeln($exception->getMessage());
            } catch (SystemException $exception) {
                //Куда-нибудь логировать
            }
        }
    }

    /**
     * TODO:
     *
     * @param $date
     * @param $type
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected function validate(
        $date,
        $type
    ): \Symfony\Component\Validator\ConstraintViolationListInterface {
        $constraint = new Collection(
            [
                'datetime' => new LessThanOrEqual('now'),
                'type' => new Choice([
                    RateLocator::TYPE_CBR,
                    RateLocator::TYPE_CASH_CBR
                ])
            ]
        );

        $errors = $this->validator->validate([
            'datetime' => $date,
            'type' => $type
        ], $constraint);

        return $errors;
}
}