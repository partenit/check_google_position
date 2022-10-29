<?php

namespace App\Command;

use App\Service\GoogleSearchService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'check:seo',
    description: 'Check SEO position of a website in google',
)]
class CheckSeoCommand extends Command
{
    public function __construct(
        private GoogleSearchService $googleSearchService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('query', InputArgument::REQUIRED, 'Query for google search')
            ->addOption('pattern', null, InputOption::VALUE_REQUIRED, 'Pattern of url to search')
            ->addOption('lang', null, InputOption::VALUE_OPTIONAL, 'Language of google search', 'ru')
            ->addOption('top', null, InputOption::VALUE_OPTIONAL, 'Top results to search', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Searching... ');

        $position = $this
            ->googleSearchService
            ->getTopPosition(
                $input->getArgument('query'),
                $input->getOption('pattern'),
                $input->getOption('lang'),
                (int) $input->getOption('top')
            );

        $output->writeln("Found at position: {$position}");

        return Command::SUCCESS;
    }
}
