## Setup XDebug with PHPStorm

```sh
# Specific to linux
$ export XDEBUG_REMOTE_HOST=$(/sbin/ip route|awk '/kernel.*metric/ { print $9 }')
```
