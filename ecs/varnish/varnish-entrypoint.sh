#!/bin/bash

set -e
VCL=/etc/varnish/default.vcl

dd if=/dev/random of=/etc/varnish/secret count=1

exec bash -c \
  "exec varnishd -F \
  -a :6081 \
  -S /etc/varnish/secret \
  -f /etc/varnish/default.vcl \
  -s malloc,256M"

varnishlog
