## To start this application

- Run from the project root:

```
docker-compose build                     # builds the service
docker-compose run php composer install  # installs project dependencies
docker-compose up -d                     # starts "feed_merger" container & detaches the process
```
- Open [http://localhost:8080/feed](http://localhost:8080/feed)

#### - For subsequent starts:
- Run from the project root:
``
docker-compose up -d
``
#### useful docker commands
```
docker ps           # shows running containers
docker-compose down # stops and removes containers, networks, volumes
```

## Useful commands
##### The commands provided below assume there are executed from within a running container

```
docker-compose run php bin/phpunit                                           # runs unit tests
docker-compose run php bin/phpunit --coverage-html ./build/coverage-phpunit  # runs unit tests AND generates coverage report
```

