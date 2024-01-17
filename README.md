# Сервис мониторинга изменения цены
Не успел реализовать тесты и фикстуры
Консольные команды запускаются 
```
 php bin/console subscription:update_price
```
```
 php bin/console subscription:send_notifications
```
Роут для получения обьекта в формате json:
```api/subscription/{id} ```
# Наполнение бд:
- перед началом работы по добавлению сущностей необходимл выполнить команду
``` php bin/console doctrine:migrations:migrate```
- войти в контейнер mysql и ввести пароль 
```
docker exec -it <тег контейнера> mysql -u user -p
```

- вставить команды из файла mysql.txt
