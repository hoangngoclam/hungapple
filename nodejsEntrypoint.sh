#!/bin/bash

if [ -d "node_modules" ];
  then
    npm install
  else
    npm update
fi
if [ "$ENVIRONMENT" == "product" ];
    then
        npm run prod
    else
        npm run watch
fi