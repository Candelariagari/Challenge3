<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command {

    private $database;

    public function __construct(DatabaseAdapter $database){ /*We accept the database received */
        $this->database = $database;
        parent::__construct();
    }

    public function configure(){
        $this->setName('show')
            ->setDescription('Shows information about the movie.');
    }

    public function execute(InputInterface $input, OutputInterface $output){
        $this->showInformation($output);
    }

    private function showInformation(OutputInterface $output){
        $info = $this->database->fetchAll('info'); /*fetch all information form the database*/
        $table = new Table($output);

        $table->setHeaders(['Title', 'Description']) /*No lleva headers, puse para probar */
            ->setRows($info)
            ->render();
    
    }

}