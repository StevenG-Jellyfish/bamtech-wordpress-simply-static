#!/bin/sh





#
#  THIS FILE IS NOT USED (YET...)
#




DOCKERFILE="Dockerfile"
REGISTRY="213533339629.dkr.ecr.eu-west-1.amazonaws.com"
PARENT_REPO="centos:latest"
REPO="${REGISTRY}/python-gcloud"
TAG="1.0.0.3"
PROJECT="py"
TO_CLEAR=(
    ${PROJECT}_app_1
)
ATTACH_TO="${PROJECT}_app_1"
RUN=true
PUSH=false
LATEST=false

TO_CLEAR_STRING=$(IFS=, ; echo "${TO_CLEAR[*]}")

# mac colour output
export TERM="xterm-color"

# A POSIX variable
OPTIND=1 # Reset in case getopts has been used previously in the shell.

# Initialize our own variables:
VERBOSE=0

function set_summary {
SUMMARY="
Dockerfile:     $DOCKERFILE
Registry:       $REGISTRY
Parent Repo:    $PARENT_REPO
Repo:           $REPO
Tag:            $TAG
Project:        $PROJECT
To clear:       $TO_CLEAR_STRING
Attach To:      $ATTACH_TO
Run:            $RUN
Push:           $PUSH
Tag latest:     $LATEST
"
}

function show_summary {
    echo $SUMMARY
}

# Show Help message
function show_help {

    set_summary

    echo "$(basename "$0") [-h] [-c] [-n] [-p] [-l] [-t TAG] [-v] -- Build and run the dockerfile
\033[1;31m${SUMMARY}\033[0m
Options:
    -h      Show this help text
    -c      Clear only
    -p      Push the tag to the registry
    -n      No run. Build only.
    -l      Additionally tag as \":latest\"
    -v      Verbose

Arguments:
    -t TAG    Override the tag with \"*\"
"
}

function parse_options {
    while getopts "hcvfnt: $*" opt; do
        case "$opt" in

        # verbose
        v)  VERBOSE=1
            ;;

        # No Run
        n)  RUN=false
            ;;

        # Tag as ":latest"
        l)  LATEST=true
            ;;

        # No Run
        p)  PUSH=true
            ;;

        # Override the tag
        t)  TAG="$2"
            set_summary
            shift # past argument
            ;;

        # help
        h)
            show_help
            exit 0
            ;;

        # Clear only
        c)  clear_existing
            exit 0
            ;;

        *)  echo "unknown"
            exit 0
            ;;

        esac
    done

    shift $((OPTIND-1))

    [ "$1" = "--" ] && shift
}

# Function to build the current repo and push it to the registry
function build {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    # Pull the latest version of the parent repo (ignore the local cache)
    #docker pull $PARENT_REPO

    # build the current dockerfile and tag it
    docker build -f $DOCKERFILE -t $REPO:$TAG .
}

# Function to tag the build as ":latest"
function latest {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    # build the current dockerfile and tag it
    echo "Tagging: $REPO:latest"
    docker tag $REPO:$TAG $REPO:latest
}

function push {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    # Push the tag to the registry
    docker push $REPO:$TAG

    if [ "$LATEST" = true ] ; then
        docker push $REPO:latest
    fi
}

# Stop all existing containers in the "TO_CLEAR" list and then remove all stopped containers
function clear_existing {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    if [ "${#TO_CLEAR[@]}" -gt 0 ]; then

        # Loop the the items in the TO_CLEAR array
        for i in "${TO_CLEAR[@]}"; do

            # stop the containers
            docker stop $i

        done

        # remove all stopped containers
        docker rm $(docker ps --all -q -f status=exited) > /dev/null 2>&1
    fi
}

# Perform local preparations before running the container
function prepare {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    # Pull the latest version of the docker repoß
    docker pull $REPO
}

# The main startup routine for this repo
function run {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    # Start all the services
    docker-compose -f docker-compose.yml -p $PROJECT up -d
    #docker-compose -f docker-compose.yml --verbose -p $PROJECT up -d

    # The entrypoint is mapped via volume and permissions will be inherited from the host.
    # So here we make sure the entrypoint script is executable
    chmod +x ./entrypoint.sh

    # Run the composer install
}

# Show the status of current containers
function list_containers {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    # Sleep for a second to give problematic containers a moment to error and close
    docker logs $ATTACH_TO || true
    sleep 1

    # output the logs of the container we will attach to
    docker logs $ATTACH_TO || true

    # remove all stopped containers
    #docker rm $(docker ps --all -q -f status=exited) || true

    # Show us the container status (exclude rancher containers)
    docker ps -a | grep -v rancher
}

function attach {

    echo "\n\033[1;31m[ ${FUNCNAME} ]\033[0m"

    # Attach to the main container
    docker attach $ATTACH_TO
}

# The main function calls
parse_options $*
show_summary
build

if [ "$LATEST" = true ] ; then
    latest
fi

if [ "$PUSH" = true ] ; then
    push
fi

if [ "$RUN" = true ] ; then
    clear_existing
    prepare
    run
    list_containers
    attach
    exit
fi
