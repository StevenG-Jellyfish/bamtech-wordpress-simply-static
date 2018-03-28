FROM alpine:latest
MAINTAINER "mohammed.mudhir@jellyfish.local "

RUN apk --update add varnish bash && rm -rf /var/cache/apk/*

COPY varnish-entrypoint.sh /usr/local/bin/varnish-entrypoint.sh
COPY default.vcl /etc/varnish/default.vcl

EXPOSE 80
ENTRYPOINT ["varnish-entrypoint.sh"]
