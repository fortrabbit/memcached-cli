<?php

namespace fortabbit\MemcachedCli\Memcached;

/**
 * Class Finder
 *
 * @package fortabbit\MemcachedCli\Memcached
 */
class Finder
{
    /**
     * @var \Memcached
     */
    private $client;

    /**
     * @var array
     */
    private $keys = [];


    /**
     * Finder constructor.
     *
     * @param \Memcached $client
     */
    public function __construct(\Memcached $client)
    {
        $this->client = $client;
        $this->client->setOption(\Memcached::OPT_BINARY_PROTOCOL, false);
    }


    /**
     * @param string $pattern
     *
     * @return $this
     */
    public function pattern(string $pattern = '*')
    {
        $this->keys = $this->client->getAllKeys() ?: [];
        $this->keys = array_filter($this->keys, function ($entry) use ($pattern) {
            return fnmatch($pattern, $entry);
        });

        return $this;
    }


    /**
     * @param int $limit
     *
     * @return array
     */
    public function find(int $limit = 100): array
    {
        if (count($this->keys) == 0) {
            return [];
        }

        $this->keys = array_slice($this->keys, 0, $limit);
        $items      = $this->client->getMulti($this->keys);

        foreach ($items as $key => $value) {
            $items[$key] = new CacheItem($key, $value);
        }

        return $items;
    }
}
