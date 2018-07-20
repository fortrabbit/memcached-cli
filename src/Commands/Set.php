<?php

namespace fortabbit\MemcachedCli\Commands;

use fortabbit\MemcachedCli\ConsoleOutput;
use fortabbit\MemcachedCli\Memcached\Client;
use Symfony\Component\Console\Input\InputInterface;

class Set
{

    /**
     * @param string                                          $key
     * @param                                                 $value
     * @param int                                             $ttl
     * @param null                                            $type
     * @param \fortabbit\MemcachedCli\ConsoleOutput          $output
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return int
     */
    public function __invoke(string $key, $value, int $ttl = 86400, $type = null, ConsoleOutput $output, InputInterface $input)
    {
        $mc  = Client::connect($input);
        $call = "Memcached::set('{$key}', '{$value}', {$ttl})";

        if ($type) {
            settype($value, $type);
        }

        if ($mc->set($key, $value, $ttl)) {
            $output->successBlock($call);
            return ConsoleOutput::EXIT_SUCCESS;
        }

        $output->errorBlock([$call, $mc->getResultMessage()]);
        return ConsoleOutput::EXIT_ERROR;

    }
}
