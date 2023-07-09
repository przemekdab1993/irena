<?php

namespace App\Command;

use App\Repository\AppUserRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;

#[AsCommand(
    name: 'app:newsletter:send',
    description: 'Add a short description for your command',
)]
class NewsletterCommand extends Command
{
    private string $newsletterEmail = 'newsletter@gmail.com';

    protected function configure(): void
    {
        $this
            ->setDescription('Send days report country for verification');
    }

    public function __construct(private AppUserRepository $appUserRepository ,private CountryRepository $countryRepository, private MailerInterface $mailer)
    {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->appUserRepository->findAllSubscribeToNewsletter();

        $io->progressStart(count($users));

        foreach ($users as $user) {
            $io->progressAdvance();

            $newCountries = $this->countryRepository->findAllNewCountries();

            $email = (new TemplatedEmail())
                ->from($this->newsletterEmail)
                ->to($user->getEmail())
                ->subject('Newsletter country!!!')
                ->htmlTemplate('email/newsletter.html.twig')
                ->context([
                    'user' => $user,
                    'newCountries' => $newCountries
                ]);


            $this->mailer->send($email);
        }

        $io->progressFinish();

        $io->success('Send report for new country');
        return false;
    }
}
