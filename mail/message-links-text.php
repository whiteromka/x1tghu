<?php
/** @var Message $message */
/** @var string $editLink */
/** @var string $deleteLink */

use app\models\Message;

?>
Управление вашим сообщением

Здравствуйте, <?= $message->name ?>!

Вы отправили сообщение на StoryValut.
Вот ссылки для управления им:

РЕДАКТИРОВАТЬ СООБЩЕНИЕ:
(доступно в течение 12 часов после отправки)
<?= $editLink ?>

УДАЛИТЬ СООБЩЕНИЕ:
(доступно в течение 14 дней после отправки)
<?= $deleteLink ?>

Отправлено: <?= Yii::$app->formatter->asDatetime($message->created_at, 'dd.MM.yyyy HH:mm') ?>
Это письмо отправлено автоматически, пожалуйста, не отвечайте на него.