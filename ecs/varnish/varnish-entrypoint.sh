#!/bin/bash

set -e
source /mnt/env/varnish.env
VCL=/etc/varnish/default.vcl
HOST=$(env|grep VARNISH_BACKEND_HOST| cut -d = -f 2);
PORT=$(env|grep VARNISH_BACKEND_PORT| cut -d = -f 2);

sed -i "s/VARNISH_BACKEND_HOST/$HOST/" $VCL
sed -i "s/VARNISH_BACKEND_PORT/$PORT/" $VCL

dd if=/dev/random of=/etc/varnish/secret count=1

exec bash -c \
  "exec varnishd -F \
  -a :$VARNISH_PORT \
  -S /etc/varnish/secret \
  -f /etc/varnish/default.vcl \
  -s malloc,$VARNISH_CACHE_SIZE"

varnishlog
