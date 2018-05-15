FROM gcr.io/jellyfish-development-167809/nginx:0.0.0.2

COPY conf/default.conf /etc/nginx/conf.d/default.conf

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && mkdir -p /usr/share/nginx/cache/fcgi


STOPSIGNAL SIGQUIT

CMD ["nginx", "-g", "daemon off;"]
