# New Docker WordPress Base Image
#
#This repository contains the Base Wordpress image. When creating a new WordPress project, you should download a zip of this repository and commit to a new repository.

# Steps to setup the project on local docker: 

set the host.env file:

```bash
cp host.env.default host.env
```
Modify the host.env to from project.local to localhost

Start the containers:

```bash
docker-compose up -d
```

1st time this will take a couple of minutes as it will need to build the images and install the required wordpress plugins.

Browser to http://localhost to view the site

## Help


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


