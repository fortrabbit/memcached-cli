## Memcached Cli 

## Available commands

```
// R/W access
php vendor/bin/mcc set [key] [value]
php vendor/bin/mcc get [key]
php vendor/bin/mcc delete [key]

// Insights
php vendor/bin/mcc stats
php vendor/bin/mcc search [pattern]

// Dev tooling
php vendor/bin/mcc faker [prefix]
php vendor/bin/mcc flush 
```

## Getting started


```
# Install via composer
composer require fortrabbit/memcached-cli
```

```
# Tell the cli the memcached server 
export MEMCACHE_HOST=localhost

# List commands
php vendor/bin/mcc
```
