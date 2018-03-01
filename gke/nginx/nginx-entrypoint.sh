#!/bin/bash

BUCKET=${BUCKET_NAME}

if [[ -d "/media/cache" ]]; then
 echo "Linking cache up"
 ln -s /media/cache /var/www/html/wp-content/cache && \
 chmod 777 /media/cache
else
 echo "Something went wrong during initialisation, check YAML file and volumes!"
fi 

if [[ -d "/media/uploads" ]]; then
 echo "Linking uploads up"
 rm -rf /var/www/html/wp-content/uploads && \
 ln -s /media/uploads /var/www/html/wp-content/uploads && \
 chmod 777 /media/uploads
else
 echo "Something went wrong during initialisation, check YAML file and volumes!"
fi

#if [[ -d "/mnt/$BUCKET" ]]
#then
#  echo "Mount Point exists!, remounting" && \
#  gcsfuse --implicit-dirs -o allow_other --uid 82 --gid 82 ${BUCKET_NAME} /mnt/${BUCKET_NAME} && \
#  rm -rf /var/www/html/wp-content/uploads && \
#  ln -s /mnt/${BUCKET_NAME}/uploads/ /var/www/html/wp-content/
#else
#  echo "Mount Point Needs Creating!" && \
#  mkdir /mnt/$BUCKET && \
#  gcsfuse --implicit-dirs -o allow_other --uid 82 --gid 82 ${BUCKET_NAME} /mnt/${BUCKET_NAME} && \
#  rm -rf /var/www/html/wp-content/uploads && \
#  ln -s /mnt/${BUCKET_NAME}/uploads/ /var/www/html/wp-content/
#fi

exec "$@"
