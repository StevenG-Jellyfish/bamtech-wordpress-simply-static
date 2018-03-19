FROM alpine:latest
MAINTAINER "mohammed.mudhir@jellyfish.local "

RUN apk --update add varnish bash && rm -rf /var/cache/apk/*
RUN mkdir -p /mnt/env/

COPY varnish-entrypoint.sh /usr/local/bin/varnish-entrypoint.sh
COPY varnish.env /mnt/env/varnish.env
COPY default.vcl /etc/varnish/default.vcl

EXPOSE 6108

ENTRYPOINT ["varnish-entrypoint.sh"]
