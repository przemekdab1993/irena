<?php

namespace App\Command;

use App\Repository\CountryRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;

#[AsCommand(
    name: 'app:new-country-for-verification:send',
    description: 'Add a short description for your command',
)]
class NewCountryForVerificationSendCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setDescription('Send days report country for verification');
    }

    public function __construct(private CountryRepository $countryRepository, private MailerInterface $mailer)
    {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $unverifiedCountries = $this->countryRepository->findAllByNotVerification();

        $io->progressStart(count($unverifiedCountries));

        foreach ($unverifiedCountries as $country) {
            $io->progressAdvance();

//            $email = (new TemplatedEmail())
//                ->from('registration@ufo.com')
//                ->to($this->adminEmail)
//                ->subject('Registration confirm!!!')
//                ->htmlTemplate('email/admin_info.html.twig');
//
//
//            $this->mailer->send($email);
        }

        $io->progressFinish();

        $io->success('Send report for new country');
        return false;
    }
}
