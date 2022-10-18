## Тестовое задание

Даны два списка. Список автомобилей и список пользователей.
C помощью laravel сделать api для управления списком использования автомобилей пользователями.
В один момент времени 1 пользователь может управлять только одним автомобилем. В один момент времени 1 автомобилем может управлять только 1 пользователь.

- Код разместить на https://github.com/
- Подготовить документацию в https://editor.swagger.io/
- Обязательно наличие тестов.

### Как развернуть проект для разработки

Инструкция с использованием Docker (MacOS, Linux):

```bash

cp .env.example .env

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    
./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate --seed

./vendor/bin/sail test
```