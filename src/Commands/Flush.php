<?php

namespace fortabbit\MemcachedCli\Commands;

use fortabbit\MemcachedCli\ConsoleOutput;
use fortabbit\MemcachedCli\Memcached\Client;
use Symfony\Component\Console\Input\InputInterface;

class Flush
{

    public function __invoke(ConsoleOutput $output, InputInterface $input)
    {
        $mc = Client::connect($input);

        $output->successBlock('Yeah');
        $output->errorBlock('Yeah');

        var_dump($mc->flush());
    }
}
