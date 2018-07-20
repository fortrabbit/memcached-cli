<?php

namespace fortabbit\MemcachedCli\Memcached;

/**
 * Class Statistics
 *
 * @package fortabbit\MemcachedCli\Memcached
 */
class Statistics
{
    /**
     * @var \Memcached
     */
    private $client;

    /**
     * @var array
     */
    private $data;


    public function __construct(\Memcached $client)
    {
        $this->client = $client;
        $this->data   = $this->client->getStats();
    }


    /**
     * Generic getter
     *
     * @param      $key
     * @param null $server
     *
     * @return null
     */
    public function get($key, $server = null)
    {
        if ($server && isset($this->data[$server][$key])) {
            return $this->data[$server][$key];
        }

        // merge or not?
        foreach ($this->data as $server => $data) {
            if (isset($data[$key])) {
                // pic the first for now
                return $data[$key];
            }
        }

        return null;

    }

    public function getUptime()
    {
        return $this->get('uptime');
    }

    public function getGetHitRate()
    {
        $hits = $this->get('get_hits');
        $total = $this->get('cmd_get');

        if ($total == 0) {
          return 0;
        }

        return ($hits / $total) * 100;
    }

    public function getGetMissRate()
    {
        return 100 - $this->getGetHitRate();
    }

    public function getUsagePercent()
    {
        $limit = $this->get('limit_maxbytes');
        $used = $this->get('bytes');

        return ($used == 0) ? $used : ($used/$limit)*100;
    }



}
