### Запуск
Для корректной работы приложения достаточно установить `docker` и `docker-compose`.

```bash
$ cd docker/
$ docker-compose up -d 
```
Приложение - http://localhost:8180/

### Остановить
```bash
$ cd docker/
$ docker-compose down 
```
### Подключение к базе данных

- `Host`: mysql
- `User`: root
- `Password`: 123

Используй PhpMyAdmin - http://localhost:8181/

Или
```bash
$ cd docker/
$ docker-compose exec mysql bash
$ mysql -u root -p
```

### Описание

Простой PHP framework. Реализован архитектруный паттер `MVC` (Model View Controller), паттер контроля маршрутов `Router`, контроль доступа к частям приложения `ACL`.

В директории `application/` находятся файлы бизнес-логики приложения. В директории `public/` находятся ресурстные файлы приложеия (изображения, шрифты, css-файлы, js-файлы и т.д.)

### application/core

В этой папке описано ядро фреймворка, классы `Model`, `View`, `Controller` и `Router`.

### application/config

В этой папке находятся файл `db.php` с данными о подключении к баде данных и файл `routes.php` с описанием доступных маршрутов.

В файле `db.php` нужно указать `host`, `user`, `password`, `db` для подключения к базе данных. 

```php
return [
    'host' => 'mysql',
    'user' => 'root',
    'password' => 123,
    'db' => 'my_framework'
];
```

В файле `routes.php` нужно указать доступные маршруты. В данном примере указан маршрут `/` с котроллером `MainController` и страницей `indexAction`.

```php
return [
    '' => [
        'controller' => 'main',
        'action' => 'index'
    ]
];
```

В маршрутах можно использовать регулярные выражения и присваивать значения к переменным. В данном примере маршрут содержит регулярное выражение. Будет объявлена переменная `$user_id` с числовым значением и передана в контроллер `UserController`.
```php
return [
    'user/{user_id:\d+}' => [
        'controller' => 'user',
        'action' => 'edit'
    ]
];
```

### application/acl

В этой папке находятся файлы контроля доступа к частям приложения. Файлы нужно называть именем контроллера. Внутри файла описан ассоциативный массив, в котором нужно указать какой группе пользователей будет доступна страница контроллера.

Пользователи приложения делятся на следующие группы:
- `all` - все пользователи;
- `authorize` - авторизованные пользователи;
- `guest` - не аторизованные пользователи;
- `admin` - администраторы.

В данном примере описан acl-файл контроллера `Main` с соответствующим именем `main.php`. Страница `index` доступна всем пользователям.
```php
return [
    'all'=> [
        'index'
    ],
    'authorize'=> [

    ],
    'guest'=> [

    ],
    'admin'=> [

    ],
];
```

### application/controllers

В этой папке находятся контроллеры, которые наследуются от класса `Controller`. Имена наследуюмых классов должны заканчинаваться на `Controller`. Пример: `ExampleController`.

В данном примере представлен контроллер `MainController` со страницей `indexAction`. Методы описывающие action должны заканчиваться на `Action`. Внутри action выполняется метод предстовления `render()`, который собирает страницу из шаблонов. Метод принимает значения: `title` страницы и массив переменных `$vars`.

```php
class MainController extends Controller
{
    public function indexAction() {

        $vars = [
            'name' => 'mvc-php-framework'
        ];
        $this->view->render('main', $vars);
    }
}
```