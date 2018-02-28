# Bamtech wordpress depoloyment on AWS ECS

This repository contains the wordpress child image. When creating a new WordPress project, you should download a zip of this repository and commit to a new repository.

# Installation

* Please fork the repository.

* In your dev container run the following commands (USE YOUR USERNAME):

```bash
cd /home/sites
git clone git@github.com:YOUR-USERNAME/wordpress-child.git
cd /home/sites/wordpress-child
git remote add upstream git@github.com:JellyfishGroup//wordpress-child.git
git remote set-url --push upstream no-pushing
```

# General Commands
## Running the image

First configure the environment for your local machine (or docker vm)
```bash
cp host.env.default host.env
nano host.env
```

Then replace "project" with your local machine values: e.g.
```bash
WP_SITEURL=http://mmdk7.shard-dev.jellyfish.local/
WP_HOME=http://mmdk7.shard-dev.jellyfish.local/
WP_CONTENT_URL=http://mmdk7.shard-dev.jellyfish.local/wp-content
```

## Goggle Cloud
You need to authenticate against GCloud SDK to access docker images:
```bash
https://accounts.google.com/o/oauth2/auth?redirect_uri=urn%3Aietf%3Awg%3Aoauth%3A2.0%3Aoob&prompt=select_account&response_type=code&client_id=32555940559.apps.googleusercontent.com&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcloud-platform+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fappengine.admin+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcompute+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Faccounts.reauth&access_type=offline
```

You'll need to use your Jellyfish email account e.g. name.lastname@jellyfish.co.uk, be aware that this has to be yor main account, if you have them associated and keep e.g. name.lastname@gmail.com as primary won't authenticate since gcloud uses this primary email as unique ID.

Click "Allow" and you're done.

Back in your console type:
```bash
gcloud init

* select YourEmail@jellyfish.co.uk
* Initialize existing configuration
(You'll be able to see all available images if your authentication was sucessfull)
```

Checking for available images:
```bash
docker ps -a
```

You'll be able to see something similar to this:
```bash
CONTAINER ID   IMAGE                  COMMAND                  CREATED        STATUS         PORTS                                      NAMES
d12ddea9758c   client_redis           "docker-entrypoint..."   6 days ago     Up 6 days      6379/tcp                                   client_redis_1
df73d2e7d9ce   client_nginx           "nginx -g 'daemon ..."   6 days ago     Up 6 days      0.0.0.0:80->80/tcp, 0.0.0.0:443->443/tcp   client_nginx_1
ccea0ccf30ae   client_elasticsearch   "/docker-entrypoin..."   6 days ago     Up 6 days      127.0.0.1:9200->9200/tcp, 9300/tcp         client_elasticsearch_1
626fd4f8008e   client_wordpress       "wordpress-entrypo..."   6 days ago     Up 6 days      9000/tcp                                   client_wordpress_1
aa28f196cb73   client_db              "docker-entrypoint..."   6 days ago     Up 6 days      3306/tcp                                   client_db_1
```

If there's no images then your SKD authentication failed.
Finally to start (and restart) the environment, run:
```bash
./run.py
```

# Other useful comands
## Stopping the image
```bash
./run.py stop
```

## Help
To see help text run:
```bash
./run.py -h
```

# WP CLI
## Searching for Plugins
```bash
./run.py plugin search PLUGIN_NAME
```

When you have found the plugin, add the slug to the "PLUGINS" array in:
```bash
./wordpress/wordpress-entrypoint.sh
```

## Run any WP CLI Command
To run any WP-CLI command you can run (in quotes):
```bash
./run.py cli "COMMAND"
```

# Attaching to containers
## Attach to the default container
```bash
./run.py attach
```

## Attach to another container
```bash
./run.py attach CONTAINER_NAME
```

# Cleanup
## Cleanup: delete all images
```bash
./run.py cleanup -i
```

## Cleanup: delete all networks
```bash
./run.py cleanup -n
```

## Cleanup: delete all containers
```bash
./run.py cleanup -c
```

## Cleanup: delete all volumes
```bash
./run.py cleanup -v
```

## Cleanup: delete all images, containers, networks and volumes
```bash
./run.py cleanup -a
```

