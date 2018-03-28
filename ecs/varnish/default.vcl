vcl 4.0;

backend default {
    .host = "nginx";
    .port = "8080";
}

acl purge {

    "localhost";
    "127.0.0.1";

}

# This function is used when a request is send by a HTTP client (Browser)
sub vcl_recv {


    if ( req.url ~ "admin-ajax" ) {

        if (req.http.Cookie ~ "wordpress_logged_in") {

            return (pass) ;

        }

        return (hash);
    }



    # --- WordPress specific configuration
    if (req.url ~ "wp-(login|admin)(?!/admin-ajax)") {

        return (pass);

    }

    include "/etc/varnish/cfg/purge.cfg";
    include "/etc/varnish/cfg/cookie_clean.cfg";


    # Post requests will not be cached
    if (req.http.Authorization || req.method == "POST") {
        return (pass);
    }

    # Bypass cache if wp admin or preview is true
    if ( req.url ~ "wp-(login|admin(?!/admin-ajax)|preview=true)") {
        return (pass);
    }


    include "/etc/varnish/cfg/gzip.cfg";

    # Cache all others requests
    return (hash);
}

sub vcl_pipe {
    return (pipe);
}

sub vcl_pass {
    return (fetch);
}

# The data on which the hashing will take place
sub vcl_hash {

    hash_data(req.url);

    if (req.http.host) {
        hash_data(req.http.host);
    } else {
        hash_data(server.ip);
    }

    # If the client supports compression, keep that in a different cache
    if (req.http.Accept-Encoding) {
            hash_data(req.http.Accept-Encoding);
    }

    return (lookup);
}

# This function is used when a request is sent by our backend (Nginx server)
sub vcl_backend_response {

    # Remove some headers we never want to see
    unset beresp.http.Server;
    unset beresp.http.X-Powered-By;

    # For static content strip all backend cookies
    if (bereq.url ~ "\.(css|js|png|gif|jp(e?)g)|swf|ico") {
        unset beresp.http.cookie;
    }

    # Don't store backend
    if (bereq.url ~ "wp-(login|admin)(?!/admin-ajax)" || bereq.url ~ "preview=true") {
        set beresp.uncacheable = true;
        set beresp.ttl = 30s;
        return (deliver);
    }


    # Only allow cookies to be set if we're in admin area
    if (!(bereq.url ~ "(wp-login|wp-admin|preview=true)")) {
            unset beresp.http.set-cookie;
    }

    # don't cache response to posted requests or those with basic auth
    if ( bereq.method == "POST" || bereq.http.Authorization ) {
        set beresp.uncacheable = true;
        return (deliver);
    }

    if ( beresp.status > 400 && beresp.status != 404 ) {
        unset beresp.http.Expires;
        unset beresp.http.Pragma;
        set beresp.uncacheable = true;
        set beresp.ttl = 30s;
        return (deliver);
    }


    if ( bereq.url ~ "/wp\-admin/admin\-ajax\.php" ){


        if (bereq.http.Cookie ~ "wordpress_logged_in") {
            set beresp.uncacheable = true;
            return (deliver);
        }


        unset beresp.http.Expires;
        unset beresp.http.Pragma;

         # Marker for vcl_deliver to reset Age: /
        set beresp.http.magicmarker = "1";

        set beresp.ttl = 5m;
        set beresp.grace = 5m;

        return (deliver);

    }

    # A TTL of 1h
    set beresp.ttl = 30m;

    # Define the default grace period to serve cached content
    set beresp.grace = 20s;

    return (deliver);
}

sub vcl_deliver {

    if (resp.http.magicmarker) {
        unset resp.http.magicmarker;
        set resp.http.Age = "0";
    }

    if (obj.hits > 0) {
        set resp.http.X-Cache = "cached";
    } else {
        set resp.http.x-Cache = "uncached";
    }

    # Remove some headers: PHP version
    unset resp.http.X-Powered-By;

    # Remove some headers: Apache version & OS
    unset resp.http.Server;

    # Remove some heanders: Varnish
    unset resp.http.Via;
    unset resp.http.X-Varnish;

    return (deliver);
}

sub vcl_init {
    return (ok);
}

sub vcl_fini {
    return (ok);
}
