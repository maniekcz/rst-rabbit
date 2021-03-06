#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php "$@"
fi

set -e

echo ">> Waiting for rabbitMQ to start"
WAIT=0
while ! nc -z rabbit 5672; do
  sleep 1
  echo "   rabbitMQ not ready yet"
  WAIT=$(($WAIT + 1))
  if [ "$WAIT" -gt 20 ]; then
    echo "Error: Timeout when waiting for rabbitMQ socket"
    exit 1
  fi
done

echo ">> rabbitMQ socket available, resuming command execution"

exec "$@"