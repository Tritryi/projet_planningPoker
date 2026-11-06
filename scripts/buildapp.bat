cd .\code
call composer install
call php ./bin/phpunit tests
call symfony server:start -d
start http://127.0.0.1:8000