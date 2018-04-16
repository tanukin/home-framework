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