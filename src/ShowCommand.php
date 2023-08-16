<?php namespace Acme;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command {

    public function configure(){
        $this->setName('show')
            ->setDescription('Shows information about the movie.')
            ->addArgument('movieTitle', InputArgument::REQUIRED, 'Title of movie to provide information.')
            ->addOption('fullPlot', null,  InputOption::VALUE_OPTIONAL, 'Show the fullplot of the movie.', 'short');
    }

    public function execute(InputInterface $input, OutputInterface $output){

        $movieTitle = $input->getArgument('movieTitle');
        $plot = $this->getPlot($input);
        $information = $this->getInformation($movieTitle, $plot);
        $this->showInformation($information, $output);
        return 0; 
    }

    public function getPlot(InputInterface $input){
        $plot = "short";
        $fullPlot = $input->getOption('fullPlot');
        if ($fullPlot == null){
            $plot = "full";
        }
        return $plot;
    }
    
    private function getInformation($movieTitle, $plot){ 
        $apikey = "6750a9de";
        $data = "https://www.omdbapi.com/?t={$movieTitle}&plot={$plot}&apikey={$apikey}";
        $information = json_decode(file_get_contents($data), true);
        
        return $information;
    }

    private function showInformation($information, OutputInterface $output){
        $output->writeln("<info>{$information['Title']} {$information['Year']}</info>");

        $this->showPlotInTable($information, $output);
        
    }

    private function showPlotInTable($information, OutputInterface $output){
        $table = new Table($output);

        foreach($information as $key => $val){
            if (is_array($val)) {
                $val = json_encode($val);
            }
            $table->addRow([$key, wordwrap($val, 150, "\n", false)]);
        }
    
        
        $table->render();
    }
}