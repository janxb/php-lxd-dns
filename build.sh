#!/bin/bash

php -d phar.readonly=off vendor/bin/phar-composer build .
