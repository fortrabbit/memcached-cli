<?php

namespace fortabbit\MemcachedCli\Commands;

use fortabbit\MemcachedCli\ConsoleOutput;
use fortabbit\MemcachedCli\Memcached\Client;
use Symfony\Component\Console\Input\InputInterface;

class Faker
{

    public function __invoke(string $prefix, int $count = 100, int $size = 1024, int $ttl = 86400, ConsoleOutput $output, InputInterface $input)
    {
        $mc = Client::connect($input);

        $value      = str_repeat('1', $size);
        $totalBytes = $size * $count;

        foreach (range(0, $count) as $num) {
            $key = $prefix . $num;
            $mc->set($key, $value, $ttl);
        }

        $output->successBlock("$totalBytes bytes stored");

        return ConsoleOutput::EXIT_SUCCESS;

    }
}
