<<<<<<< master
# Bamtech Wordpress Dockerized

![alt text](http://www.multichannel.com/sites/default/files/public/styles/blog_content/public/blog-images/bamtech%20logo_0.jpg)

# Steps to set Docker CE on your Mac: 

Set the host.env file:

```bash
cp host.env.default host.env
```
Modify the host.env to from project.local to localhost

Start the containers:

```bash
docker-compose up -d
```

Detailed information here: 
https://jellyfish.atlassian.net/wiki/spaces/WIKI/pages/169213981/Set+Docker+CE+on+your+MAC


On 1st time deployment will take a couple of minutes as it will need to build the images and install the required wordpress plugins.

Browser to http://localhost to view the site, if you see a 502 Gateway error means the deployment still executing, wait few minutes till is completed.
=======
# Bamtech wordpress dockerized
#

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
>>>>>>> master

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

