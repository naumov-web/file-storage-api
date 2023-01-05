#!/bin/bash

echo "Run Docker containers!"

if [ ! -f .env ]; then
  cp .env.local .env
fi

docker-compose up
