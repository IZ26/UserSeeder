<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;
use PDO;


class UserSeeder extends Command
{
    private $pdo;
    private $faker;

    public function __construct($pdo, $faker)
    {
        parent::__construct();
        $this->pdo = $pdo;
        $this->faker = $faker;
    }

    protected function configure()
    {
        $this->setName('seed:users')
            ->setDescription('Send new user to db')
            ->setHelp('This command help you to generate user information to db')
            ->addOption('count', 'c', InputOption::VALUE_REQUIRED, 'How many user you want to send to your db', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progressBar = new ProgressBar($output, $input->getOption('count'));

        for ($i = 0; $i < $input->getOption('count'); $i++) {
            $progressBar->advance();
            $query = $this->pdo->prepare('INSERT INTO users (first_name, last_name, email) VALUES ("'.$this->faker->firstname.'", "'.$this->faker->lastname.'","'.$this->faker->email.'")');
            $query->execute();
        }
        $progressBar->finish();
    }
}
