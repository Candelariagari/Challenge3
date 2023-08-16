<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
#use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command {

    public function configure(){
        $this->setName('show')
            ->setDescription('Shows information about the movie.')
            ->addArgument('movieTitle', InputArgument::REQUIRED, 'Title of movie to provide information.');
    }

    public function execute(InputInterface $input, OutputInterface $output){

        $movieTitle = $input->getArgument('movieTitle');
    
        $information = $this->getInformation($movieTitle);
        $this->showInformation($information, $output);
        return 0; 
    } 
    
    private function getInformation($movieTitle){ 
        $apikey = "6750a9de";
        $data = "https://www.omdbapi.com/?t={$movieTitle}&apikey={$apikey}";
        $information = json_decode(file_get_contents($data), true);
        
        return $information;
    }

    private function showInformation($information, OutputInterface $output){
        $output->writeln("<info>{$information['Title']} {$information['Year']}</info>");
        $output->writeln($information);
        // $message = $movieTitle. ' - Year';
        
        // $output->writeln("<info>{$message}</info>");

        // $table = new Table($output);

        // $table->setHeaders(['Title', 'Description']) //No lleva headers, puse para probar 
        //     ->setRows($information)
        //     ->render();
    
    }
}