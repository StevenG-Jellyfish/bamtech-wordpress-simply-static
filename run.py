#!/usr/bin/python
from cement.core.foundation import CementApp
from cement.core.controller import CementBaseController, expose
from cement.utils.misc import init_defaults
#from oauth2client.client import GoogleCredentials
import subprocess
import os, sys, traceback
import signal

# Set the google credentials
#credentials = GoogleCredentials.get_application_default()

# change the working dir to the scripts own directory
abspath = os.path.abspath(__file__)
dname = os.path.dirname(abspath)
os.chdir(dname)

PROJECT = "client"
MAIN_CONTAINER = "wordpress"

# Base controller, all custom controllers should inherit from this controller
class MyBaseController(CementBaseController):
    class Meta:
        label = 'base'
        description = "Docker %s run" % PROJECT

    @expose(hide=True)
    def run_cli_command(self, command):
        self.app.log.info("[ DESC ] Running command: %s" % command)
        proc = subprocess.Popen(command, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        while proc.poll() is None:
            line = proc.stdout.readline().strip()
            if line != '\n' and line != '':
                print line
        # There might still be data on stdout at this point. Grab any remaining and output.
        for line in proc.stdout.read().split('\n'):
            line = line.strip()
            if line != '\n' and line != '':
                print line
'''
Main controller containing the core start stop actions
'''
class MainController(MyBaseController):
    class Meta:
        label = 'base'
        description = "Docker %s run" % PROJECT

    @expose(hide=True)
    def default(self):
        # Stop
        self.stop()

        # Remove
        self.rm()

        # Build
        self.build()

        # Run
        self.start()

    @expose(help="Stop the existing containers for this project")
    def stop(self):
        containers_to_remove=[
            '%s_%s_1' % (PROJECT, MAIN_CONTAINER),
            '%s_redis_1' % PROJECT,
            '%s_nginx_1' % PROJECT,
            '%s_db_1' % PROJECT,
            '%s_elasticsearch_1' % PROJECT,
        ]

        self.app.log.info("Stopping containers (volumes remain)...")

        for i in containers_to_remove:
            self.run_cli_command("docker stop %s" % i)

    @expose(help="Remove the existing containers for this project")
    def rm(self):
        containers_to_remove=[
            '%s_%s_1' % (PROJECT, MAIN_CONTAINER),
            '%s_redis_1' % PROJECT,
            '%s_nginx_1' % PROJECT,
            '%s_db_1' % PROJECT,
            '%s_elasticsearch_1' % PROJECT,
        ]

        self.app.log.info("[ DESC ] Removing containers (volumes remain)...")

        for i in containers_to_remove:
            self.run_cli_command("docker rm %s" % i)

    @expose(help="Build images for this project")
    def build(self):
        self.app.log.info("[ DESC ] Building containers...")

        containers_to_build=[
#            '%s_%s_1' % (PROJECT, MAIN_CONTAINER),
#            '%s_nginx_1' % PROJECT,
#            '%s_elasticsearch_1' % PROJECT,
        ]

        for i in containers_to_build:
            self.run_cli_command("docker-compose build --no-cache --force-rm --pull %s" % i)
            #self.run_cli_command("docker-compose build %s" % i)

    @expose(help="Start the containers")
    def start(self):
        self.app.log.info("[ DESC ] Starting the containers...")

        self.run_cli_command(
            "docker-compose -f docker-compose.yml -p %s up --build -d --force-recreate"
            #"docker-compose -f docker-compose.yml -p %s up -d --force-recreate"
            % (PROJECT)
        )

        self.run_cli_command(
            "docker ps"
        )

        self.logs()

    @expose(help="Show the main logs")
    def logs(self):
        self.app.log.info("[ DESC ] Logs...")

        self.run_cli_command(
            "docker logs -f %s_%s_1" % (PROJECT, MAIN_CONTAINER)
        )

    @expose(help="Restart the containers")
    def restart(self):
        self.stop()
        self.start()

    @expose(help="Compile this script")
    def compile(self):
        import py_compile
        py_compile.compile("run.py")

'''
The push controller - used to tag and push a Dockerfile
'''
class PushController(MyBaseController):
    class Meta:
        label = 'push'
        stacked_on = 'base'
        stacked_type = 'nested'
        description = "Attach to a container - usage: ./run.py push CONTAINER_NAME"
        arguments = [
            ( ['-t', '--tag'],
              dict(action='store', dest='tag', help='Remove all containers, volumes, networks and images (full reset)') ),
        ]
    @expose(help="Tag and push the containers")
    def push(self):
        self.app.log.info("[ DESC ] Tagging...")

        self.run_cli_command(
            "docker build -f Dockerfile -t base-wordpress-php:%s wordpress/"
            % self.app.pargs.tag
        )

        self.run_cli_command(
            "docker build -f Dockerfile -t base-wordpress-elasticsearch:%s elasticsearch/"
            % self.app.pargs.tag
        )

        self.run_cli_command(
            "docker build -f Dockerfile -t base-wordpress-redis:%s redis/"
            % self.app.pargs.tag
        )

        self.run_cli_command(
            "docker build -f Dockerfile -t base-wordpress-nginx:%s nginx/"
            % self.app.pargs.tag
        )

        self.run_cli_command(
            "docker images"
        )

'''
The attach controller - used to attach to a bash prompt on any container
'''
class AttachController(MyBaseController):
    class Meta:
        label = 'attach'
        stacked_on = 'base'
        stacked_type = 'nested'
        description = "Attach to a container - usage: ./run.py attach CONTAINER_NAME"
        arguments = [
            (['container'],
             dict(help='The container to attach to', action='store', nargs='*')),
        ]

    @expose(help="Connect to a container")
    def default(self):
        if self.app.pargs.container:

            container =  "%s_%s_1" % (PROJECT, self.app.pargs.container[0])

        else:

            container =  "%s_%s_1" % (PROJECT, MAIN_CONTAINER)

        self.app.log.info("[ DESC ] Attaching to container: %s" % container)

        command = "docker exec -i -t %s /bin/bash" % container

        os.system(command)

'''
WordPress Plugin Controller used to search for plugins
Once you have found the plugin you are looking for, please add it to
the "PLUGINS" array in "./wordpress/wordpress-entrypoint.sh"
'''
class WPPluginController(MyBaseController):
    class Meta:
        label = 'plugin'
        stacked_on = 'base'
        stacked_type = 'nested'
        description = "Plugin search - usage: py run.py plugin search PLUGIN_NAME"
        arguments = [
            (['extra_arguments'],
             dict(help='Search term. i.e: "py run.py plugin search PLUGIN_NAME"', action='store', nargs='*')),
        ]

    @expose(help="Search for wordpress plugins")
    def search(self):
        if self.app.pargs.extra_arguments:
            self.app.log.info("[ DESC ] Searching for wordpress plugin: %s" % self.app.pargs.extra_arguments[0])

            command = "docker exec -i -t --user www-data %s_%s_1 /usr/local/bin/wp plugin search --per-page=100 --fields=name,slug,rating,version %s " % (PROJECT, MAIN_CONTAINER, self.app.pargs.extra_arguments[0])

            self.app.log.info("[ DESC ] Running command: %s" % command)

            os.system(command)

            self.app.log.info(
                "[ DESC ] Once you have found the plugin you are looking for, please add it to the \"PLUGINS\" array in \"./wordpress/wordpress-entrypoint.sh\""
            )
        else:
            self.app.log.warning("Please provide a plugin to search for")

'''
WordPress CLI Controller used to run any WP CLI Command
'''
class WPCLIController(MyBaseController):
    class Meta:
        label = 'cli'
        stacked_on = 'base'
        stacked_type = 'nested'
        description = "WordPress CLI - usage: py run.py cli COMMAND"
        arguments = [
            (['extra_arguments'],
             dict(help='WP CLI command. i.e: "py run.py cli option list"', action='store', nargs='*')),
        ]

    @expose(help="Search for wordpress plugins")
    def default(self):
        if self.app.pargs.extra_arguments:
            self.app.log.info("[ DESC ] Running CLI command: %s" % " ".join(self.app.pargs.extra_arguments))

            command = "docker exec -i -t --user www-data %s_%s_1 /usr/local/bin/wp %s " % (PROJECT, MAIN_CONTAINER, " ".join(self.app.pargs.extra_arguments))

            self.app.log.info("[ DESC ] Running command: %s" % command)

            # self.run_cli_command(
            #     "docker logs %s_%s_1 -f" % (PROJECT, MAIN_CONTAINER)
            # )

            os.system(command)

            self.app.log.info(
                "[ DESC ] Once you have run the CLI command you are looking for, please add it to the entrypoint script: \"./wordpress/wordpress-entrypoint.sh\""
            )
        else:
            self.app.log.warning("Please provide CLI command")

"""
The cleanup controller for resetting your environment
"""
class DockerCleanupController(MyBaseController):
    class Meta:
        label = 'cleanup'
        stacked_on = 'base'
        stacked_type = 'nested'
        description = "Docker cleanup - usage: py run.py cleanup"
        arguments = [
            ( ['-a', '--all'],
              dict(action='store_true', help='Remove all containers, volumes, networks and images (full reset)') ),
            ( ['-c', '--containers'],
              dict(action='store_true', help='Remove all containers') ),
            ( ['-v', '--volumes'],
              dict(action='store_true', help='Remove all volumes') ),
            ( ['-n', '--networks'],
              dict(action='store_true', help='Remove all networks') ),
            ( ['-i', '--images'],
              dict(action='store_true', help='Remove all images') ),
            ]

    @expose(hide=True)
    def default(self):
        if self.app.pargs.all:
            self.remove_all()
        elif self.app.pargs.containers:
            self.remove_containers()
        elif self.app.pargs.volumes:
            self.remove_volumes()
        elif self.app.pargs.networks:
            self.remove_networks()
        elif self.app.pargs.images:
            self.remove_images()
        else:
            self.app.log.warning("Please provide details on what to cleanup")

    @expose(help="Remove all containers, volumes and images (full reset)", hide=True)
    def remove_all(self):
        self.app.log.info("[ DESC ] Removing all containers, volumes, networks and images (full reset)")
        self.remove_containers()
        self.remove_volumes()
        self.remove_networks()
        self.remove_images()

    @expose(help="Remove all containers", hide=True)
    def remove_containers(self):
        self.app.log.info("[ DESC ] Removing all containers...")
        containers = subprocess.Popen(["docker ps -a -q"], shell=True, stdout=subprocess.PIPE).communicate()[0]
        containers = filter(bool, containers.split("\n"))

        if len(containers) > 0:
            containers = " ".join(containers)

            p = subprocess.Popen(["docker stop %s" % containers], shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE)
            for line in p.stdout:
                sys.stdout.write(line)
                sys.stdout.flush()

            p = subprocess.Popen(["docker rm %s" % containers], shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE)
            for line in p.stdout:
                sys.stdout.write(line)
                sys.stdout.flush()
        else:
            self.app.log.warning("[ DESC ] No containers to remove")

    @expose(help="Remove all volumes", hide=True)
    def remove_volumes(self):
        self.app.log.info("[ DESC ] Removing all volumes...")
        volumes = subprocess.Popen(["docker volume ls -f dangling=true -q"], shell=True, stdout=subprocess.PIPE).communicate()[0]
        volumes = filter(bool, volumes.split("\n"))

        if len(volumes) > 0:
            volumes = " ".join(volumes)
            p = subprocess.Popen(["docker volume rm %s" % volumes], shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE)
            for line in p.stdout:
                sys.stdout.write(line)
                sys.stdout.flush()
        else:
            self.app.log.warning("[ DESC ] No volumes to remove")

    @expose(help="Remove all networks", hide=True)
    def remove_networks(self):
        self.app.log.info("[ DESC ] Removing all networks")
        images = subprocess.Popen(["docker network ls -q | grep \"bridge\" | awk '/ / { print $1 }'"], shell=True, stdout=subprocess.PIPE).communicate()[0]
        images = filter(bool, images.split("\n"))

        if len(images) > 0:
            images = " ".join(images)

            p = subprocess.Popen(["docker network rm %s" % images], shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE)
            for line in p.stdout:
                sys.stdout.write(line)
                sys.stdout.flush()
        else:
            self.app.log.warning("[ DESC ] No networks to remove")

    @expose(help="Remove all images", hide=True)
    def remove_images(self):
        self.app.log.info("[ DESC ] Removing all images")
        images = subprocess.Popen(["docker images -q"], shell=True, stdout=subprocess.PIPE).communicate()[0]
        images = filter(bool, images.split("\n"))

        if len(images) > 0:
            images = " ".join(images)

            p = subprocess.Popen(["docker rmi -f %s" % images], shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE)
            for line in p.stdout:
                sys.stdout.write(line)
                sys.stdout.flush()
        else:
            self.app.log.warning("[ DESC ] No images to remove")

"""
The Main Run Class
"""
class DockerRunApp(CementApp):
    class Meta:
        label = 'run'
        base_controller = 'base'
        extensions = ['colorlog']
        handlers = [MainController, AttachController, WPPluginController, WPCLIController, DockerCleanupController]
        log_handler = 'colorlog'

    def exit_gracefully(self, signum, frame):
        # restore the original signal handler as otherwise evil things will happen
        # in raw_input when CTRL+C is pressed, and our signal handler is not re-entrant
        signal.signal(signal.SIGINT, original_sigint)

        try:
            sys.exit(1)

        except KeyboardInterrupt:
            print("Keyboard Interrupt: quitting")
            sys.exit(1)

        # restore the exit gracefully handler here
        signal.signal(signal.SIGINT, exit_gracefully)

with DockerRunApp() as app:
    try:
        original_sigint = signal.getsignal(signal.SIGINT)
        signal.signal(signal.SIGINT, app.exit_gracefully)
        app.run()
    except Exception:
        raise
