<?php

namespace fortabbit\MemcachedCli\Commands;

use fortabbit\MemcachedCli\ConsoleOutput;
use fortabbit\MemcachedCli\Memcached\Client;
use Symfony\Component\Console\Input\InputInterface;

class Delete
{

    public function __invoke(string $key, ConsoleOutput $output, InputInterface $input)
    {
        $mc  = Client::connect($input);
        $call = "Memcached::delete('{$key}')";

        if ($success = $mc->delete($key)) {
            $output->successBlock($call);
            return ConsoleOutput::EXIT_SUCCESS;
        }

        $output->errorBlock([$call, $mc->getResultMessage()]);
        return ConsoleOutput::EXIT_ERROR;



    }
}
