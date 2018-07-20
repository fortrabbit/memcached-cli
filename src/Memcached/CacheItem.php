<?php

namespace fortabbit\MemcachedCli\Memcached;

/**
 * Class CacheItem
 *
 * @package fortabbit\MemcachedCli\Memcached
 */
class CacheItem
{

    public $key;
    public $type;
    public $size;
    public $sizeFormatted;
    public $value;
    public $valueAsString;

    /**
     * CacheItem constructor.
     *
     * @param string $key
     * @param null   $value
     */
    public function __construct(string $key, $value = null)
    {
        $this->key = $key;

        $this->value = $value;
        $this->valueAsString = self::valueAsString($value);

        $this->type = gettype($value);

        $this->size = strlen($this->valueAsString);
        $this->sizeFormatted = self::formatBytes($this->size);
    }


    protected static function valueAsString($value)
    {
        return (!is_scalar($value)) ? json_encode($value) : (string) $value;
    }

    protected static function formatBytes($bytes)
    {
        return $bytes . ' bytes';
    }

}
