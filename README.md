# New Docker WordPress Base Image
#
#This repository contains the Base Wordpress image. When creating a new WordPress project, you should download a zip of this repository and commit to a new repository.

# Setting the environment
## Gcloud
1 - You need to have you jellyfish email added into the Google Cloud console

Login the google Cloud SDK:
https://accounts.google.com/o/oauth2/auth?redirect_uri=urn%3Aietf%3Awg%3Aoauth%3A2.0%3Aoob&prompt=select_account&response_type=code&client_id=32555940559.apps.googleusercontent.com&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcloud-platform+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fappengine.admin+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcompute+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Faccounts.reauth&access_type=offline


2 - You need to install and unpack the Google SDK depending on your machine: https://cloud.google.com/sdk/downloads

```bash
curl https://sdk.cloud.google.com | bash
```

```bash
exec -l $SHELL
```

```bash
gcloud init
```

```bash
gcloud docker --authorize-only
```

# General Commands
## Running the image

First configure the environment for your local machine (or docker vm)
```bash
cp host.env.default host.env
nano host.env
```

Then, to start (and restart) the environment, run:
```bash
./run.py
```

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


# Other useful commands
Create a database dump:
```bash
docker exec [image-name] sh -c 'exec mysqldump -uwordpress -p"wordpress" wordpress' > wordpress_dump.sql
```

Add a sql dump to database:
```bash
docker exec -i [image-name] -uwordpress -p"wordpress" wordpress < ~/wordpress_dump.sql 
```

Browse image: 
```bash
docker exec -ti [image-name] bash
```

Copy files: 
```bash
docker cp wp-stateless/ [image-name]:/var/www/html/wp-content/plugins/
```


