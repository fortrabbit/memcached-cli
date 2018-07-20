<?php

namespace fortabbit\MemcachedCli\Commands;

use fortabbit\MemcachedCli\ConsoleOutput;
use fortabbit\MemcachedCli\Memcached\Client;
use fortabbit\MemcachedCli\Memcached\Finder;
use Symfony\Component\Console\Input\InputInterface;

class Search
{

    const CROP_LIMIT = 65;

    /**
     * @param string                                          $pattern
     * @param \fortabbit\MemcachedCli\ConsoleOutput           $output
     * @param \Symfony\Component\Console\Input\InputInterface $input
     */
    public function __invoke(string $pattern, ConsoleOutput $output, InputInterface $input)
    {
        $finder = new Finder(Client::connect($input));
        $result = $finder->pattern($pattern)->find();

        $rows = [];
        $headers = ['Key', 'Size', 'Type', 'Value'];

        foreach ($result as $item) {
            /** @var \fortabbit\MemcachedCli\Memcached\CacheItem $item */
            $rows[] = [
                $item->key,
                $item->sizeFormatted,
                $item->type,
                ($item->size > self::CROP_LIMIT) ? substr($item->valueAsString, 0, self::CROP_LIMIT) . '...' : $item->valueAsString
            ];
        }

        // Draw table
        $output->table($headers, $rows);

    }
}
