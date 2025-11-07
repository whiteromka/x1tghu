<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=' . getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',
];
