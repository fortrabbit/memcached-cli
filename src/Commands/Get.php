<?php

namespace fortabbit\MemcachedCli\Commands;

use fortabbit\MemcachedCli\ConsoleOutput;
use fortabbit\MemcachedCli\Memcached\Client;
use Symfony\Component\Console\Input\InputInterface;

class Get
{

    public function __invoke(string $key, ConsoleOutput $output, InputInterface $input)
    {
        $mc  = Client::connect($input);
        $call = "Memcached::get('{$key}')";

        if ($res = $mc->get($key)) {
            $type = gettype($res);
            $output->successBlock([$call, "> ({$type}) " . print_r($res, true)]);
            return ConsoleOutput::EXIT_SUCCESS;
        }

        $output->errorBlock([$call, $mc->getResultMessage()]);
        return ConsoleOutput::EXIT_ERROR;



    }
}
