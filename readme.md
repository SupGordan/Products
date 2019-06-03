
## Products App

Развертывание проекта 

- composer install
- Скопировать в .env .env.example 
- Поменять в .env подключение к базе
- php artisan migrate для выполнения миграций
- php artisan db:seed для заполнения начальными значениями

Два REST метода 

- POST /api/create-order 
       
        Параметры:
            products        => json {product_name:quantity} с типами string:int
            address         => string Адресс доставки
            time_delivery   => Дата с форматом "Y-m-d H:i" и позднее, чем сейчас
            
- POST /api/change-status

        Параметры:
            id          => ID заказа
            status_id   => ID статуса (3 начальных статуса: 1:Новый заказ, 2:Заказ отправлен, 3:Заказ завершен)      
                 
Для получения списка заказов использовать GraphQL

- query Order с параметром id (int если нужно получить 1 заказ и массив int, если нужно получить несколько заказов, вообще без параметров). Указываем параметры, которые необходимо получить


Тесты находяться в папке tests
Команда для запуска тестов phpunit или php vendor/phpunit/phpunit/phpunit

Логика REST методов в файле app/Http/Controllers/OrdersController.php
Логика GraphQL в app/GraphQL, конфигурация в config/graphql.php