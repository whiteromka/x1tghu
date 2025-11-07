На все ушло около 10-11 часов. Но я долго пытался победить yii::t(...) для пост... И давно не работал с Yii2 многое подзабылось уже

Для развертывания:
- создать .env в корне и заполнить по примеру с .env.example
- создать и заполнить db-local.php в папке config по примеру db.php

Выполнить команды:
- docker-compose up -d
- docker-compose exec php composer install
- docker-compose exec php chmod -R 775 runtime web/assets
- docker-compose exec php chown -R www-data:www-data runtime web/assets
- docker-compose exec php php yii migrate

Готово: http://localhost:8000/

