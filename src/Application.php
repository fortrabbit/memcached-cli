<?php

namespace fortabbit\MemcachedCli;

use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;


class Application extends \Silly\Application
{


    public function getHelp()
    {
        $this->getDefinition()->setOptions([]);
        $version = sprintf('%s <fg=white>%s</>', $this->getName(), $this->getVersion());
        $rabbit  = <<<RABBIT
                              DDO            
                         7NDD8               
               8D      DDDDDDDDN?            
         8D   NDN     DDDDDDDDDDD8           
        NDN  DDD8    DDDDDDDDDDDDD           
        NDD DNDD    DNDDDDDDDDDDDDDDDDDDN    
        77D DDDD   NDDDDDDDDDDDDDDDDDDDDDD7  
         77DNDD   DDDDDDDDDDDDDDDDDD7   DNDN 
         77DDN   DDDDDDDDDDDDDDDN7       7D     $version
        DNNDDN  NDDDDDDDDZDDDD               
      IDDIDDDDD8NDDDDDDDD?  :                
     DD <fg=red>●</> DDDDDDDDDDDDDDDDDD                 
   :7DDDDDDDDDDDDDDDDDDDDN                   
   . :NNDDDDDDDDDNDDDDDDI   
                  NDDDD                      
           DDDD  DDDD                        
          DDNO  DDND                         
         NND   DDM                           
        8DZ   DD8                            
RABBIT;


        return "<fg=cyan>$rabbit</>";

    }

    protected function getDefaultCommands()
    {
        return [(new ListCommand())->setHidden(true), (new HelpCommand())->setHidden(true)];
    }

}
