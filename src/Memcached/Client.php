<?php

namespace fortabbit\MemcachedCli\Memcached;


use Symfony\Component\Console\Input\InputInterface;

/**
 * Class Client
 *
 * @package fortabbit\MemcachedCli\Memcached
 */
class Client
{

    const DEFAULT_PORT = 11211;

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param string                                          $persistentId
     *
     * @return \Memcached
     */
    public static function connect(InputInterface $input, $persistentId = 'mc'): \Memcached
    {
        // Load config
        $servers = static::getServersFromOption($input->getOption('server'));
        $servers = count($servers) == 0 ? static::getServersFromEnvVars() : $servers;

        if (count($servers) === 0) {
            throw new \InvalidArgumentException('No memcached servers configured.');
        }

        if (!extension_loaded('memcached')) {
            throw new \LogicException('memcached pecl extension is required to access Memcached');
        }


        // Add servers
        $mc = new \Memcached($persistentId);

        $mc->setOption(\Memcached::OPT_BINARY_PROTOCOL, true);
        $mc->addServers($servers);

        return $mc;
    }

    /**
     * @return array
     */
    public static function getServersFromEnvVars(): array
    {
        // Single server
        if (getenv('MEMCACHE_HOST')) {
            return [[getenv('MEMCACHE_HOST'), getenv('MEMCACHE_PORT') ?: self::DEFAULT_PORT]];
        }

        // Multiple server
        $servers = [];
        $count   = (int)getenv('MEMCACHE_COUNT');

        if ($count > 0) {
            foreach (range(1, $count) as $num) {
                $servers[] = [getenv('MEMCACHE_HOST' . $num), getenv('MEMCACHE_PORT' . $num)];
            }
        }

        return $servers;
    }

    /**
     * @param array $serverOptions
     *
     * @return array
     */
    public static function getServersFromOption(array $serverOptions = []): array
    {
        $servers = [];

        if (count($serverOptions) === 0) {
            return [];
        }
        foreach ($serverOptions as $option) {
            $option    = (strpos($option, ':') === false) ? $option . ':' . self::DEFAULT_PORT : $option;
            $servers[] = explode(':', $option, 2);
        }

        return $servers;
    }

}
