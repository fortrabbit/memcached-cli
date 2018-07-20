<?php

namespace fortabbit\MemcachedCli\Commands;

use fortabbit\MemcachedCli\ConsoleOutput;
use fortabbit\MemcachedCli\Memcached\Client;
use fortabbit\MemcachedCli\Memcached\Statistics;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;

class Stats
{
    public function __invoke($full, InputInterface $input, ConsoleOutput $output)
    {
        $stats = new Statistics(Client::connect($input));

        $output->section('Health');

        $usage = (int)ceil($stats->getUsagePercent());
        $bar   = $output->createStaticBar($usage > 60 ? ConsoleOutput::BAR_STATUS_CRITICAL : ConsoleOutput::BAR_STATUS_OK);
        $bar->setMessage("Usage");
        $bar->advance($usage);

        $missRate = (int)1;
        $bar      = $output->createStaticBar($missRate > 5 ? ConsoleOutput::BAR_STATUS_CRITICAL : ConsoleOutput::BAR_STATUS_OK);
        $bar->setMessage("Miss rate");
        $bar->advance($missRate);

        $output->section('Numbers');

        $output->table(['Metric', 'Value', 'Info'], [
            ["CMD flush", $stats->get('cmd_flush'), "Number of 'flush_all' commands (avoid flush in production)."],
            ["CMD get", $stats->get('cmd_get'), "Number of 'get' commands received since server startup."],
            ["CMD set", $stats->get('cmd_set'), "Number of 'set' commands serviced since startup."],
            new TableSeparator(),
            ["Current Items", $stats->get('curr_items'), "Number of items currently in this server's cache."],
            ['Get Hits', $stats->get('get_hits'), "Number of successful 'get' requests since server started start."],
            ['Get Misses', $stats->get('get_misses'), "Number of failed 'get' requests (item not existent or expired)."],
            new TableSeparator(),
            ['Evictions', $stats->get('evictions'), "Number of objects removed to free up memory (avoid in production)"],
            ['Uptime', $stats->getUptime(), "Seconds since server start"],

        ]);

    }
}
