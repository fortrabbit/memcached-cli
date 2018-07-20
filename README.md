##total_items	

Number of items stored ever stored on this server. This is no "maximum item count" value but a counted increased by every new item stored in the cache.

##uptime	

Numer of seconds the Memcached server has been running since last restart.1145873 / (60 * 60 * 24) = ~13 days since this server has been restarted


##bytes

Number of bytes currently used for caching items, this server currently uses ~6 MB of it's maximum allowed (limit_maxbytes) 1 GB cache size.


## evictions	

Number of objects removed from the cache to free up memory for new items because Memcached reached it's maximum memory setting (limit_maxbytes).


##get_hits	

Number of successful "get" commands (cache hits) since startup, divide them by the "cmd_get" value to get the cache hitrate: This server was able to serve 24% of it's get requests from the cache, the live servers of this installation usually have more than 98% hits.

##get_misses

Number of failed "get" requests because nothing was cached for this key or the cached value was too old.


##curr_items	

Number of items currently in this server's cache. The production system of this development environment holds more than 8 million items.


##cmd_flush

The "flush_all" command clears the whole cache and shouldn't be used during normal operation.

##cmd_get

Number of "get" commands received since server startup not counting if they were successful or not.

## cmd_set	

Number of "set" commands serviced since startup.
