<?php

namespace app\services;

use app\models\Message;
use Exception;
use Yii;

class EmailService
{
    /**
     * Отправляет письмо с ссылками на управление сообщением
     */
    public static function sendMessageLinks(Message $message)
    {
        try {
            Yii::$app->mailer->compose([
                'text' => 'message-links-text'
            ], [
                'message' => $message,
                'editLink' => self::generateLink($message, 'message/edit'),
                'deleteLink' => self::generateLink($message, 'message/delete'),
            ])
                ->setTo($message->email)
                ->setFrom([Yii::$app->params['adminEmail'] ?? 'noreply@' . Yii::$app->request->hostName => Yii::$app->name])
                ->setSubject('Ссылки для управления вашим сообщением')
                ->send();

        } catch (Exception $e) {
            Yii::error('Ошибка отправки email: ' . $e->getMessage());
        }
    }

    /**
     * Генерирует ссылку для
     */
    private static function generateLink(Message $message, string $url): string
    {
        return Yii::$app->urlManager->createAbsoluteUrl([
            $url,
            'link' => $message->link
        ]);
    }
}
