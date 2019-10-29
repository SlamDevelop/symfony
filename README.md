Toolset: Symfony 4.3, MySql 5.7, Doctrine 2.6.3, Twig, Git 2.23.0, PHP 7.3.9.

1. Откройте Git и пропишите путь до папки "www".
Пример: cd /d/you_folder/www

2. В папке "www" отредактируйте 27 строку в файле ".env" для подключения к MySql
Пример: DATABASE_URL=mysql://root:12345@127.0.0.1:3306/slamdevelop

3. В терминале Git введите "bin/console doctrine:database:create" для создания базы данных.

4. Затем введите команду "bin/console doctrine:schema:update --force" для построения таблицы.

5. Запустить локальный хост с помощью команды "symfony server:start".

6. Перейдите в браузере на "http://localhost:8000/main".

Надеюсь у вас все заработало :) .