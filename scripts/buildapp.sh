#!/bin/bash
cd ../code/
composer install
symfony server:start -d
firefox http://127.0.0.1:8000