home-framework
==============

Use

```yaml
composer install
```

```yaml
docker-compose up
```

### Request
Необходимо вывести 200 самых популярных фильмов для указанных жанров
~~~
http://127.0.0.1:8000/popular/films/by-genres?genresList=Drama,Thriller,Comedy
~~~
Необходимо вывести 50 самых популярных фильмов для указанного списка профессий
~~~
http://127.0.0.1:8000/popular/films/by-professions?professionsList=Engineer,Programmer,Marketing
~~~
Необходимо вывести 200 самых не популярных фильмов, которые были просмотрены пользователями в указанном возрастном диапазоне
~~~
http://127.0.0.1:8000/popular/films/by-age-range?fromAge=18&toAge=35
~~~
Необходимо вывести 100 фильмов, снятые в указанный период с максимальной оценкой пользоватлей
~~~
http://127.0.0.1:8000/popular/films/by-period?fromYear=1993&toYear=1997
~~~

Add a movie to the repository using rabbitMQ
===

#### Run the queue handler
```yaml
docker exec home-framework-project /var/www/bin/subscriber.php -d
```
#### RabbitMQ Management
~~~
http://localhost:15672/#/
~~~
~~~
login: guest
password: guest
~~~

#### Add a new movie
~~~
POST /film/
~~~
```json
{"title":"New Title Film","realiseDate":"2018-05-04"}
```

##### Example
~~~
POST /film/ HTTP/1.1
Host: anyName
Content-Type: application/json
Content-Length: 53

{"title":"New Title Film","realiseDate":"2018-05-04"}
~~~

