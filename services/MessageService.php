<?php

namespace app\services;

use app\models\forms\MessageForm;
use app\models\Message;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use Yii;

class MessageService
{
    /**
     * Получить сообщение по ссылке или ошибку если сообщения не найдено
     *
     * @throws NotFoundHttpException
     */
    public static function getActiveByLinkOrException(string $link)
    {
        $message = Message::find()
            ->where(['link' => $link])
            ->andWhere(['status' => Message::STATUS_ACTIVE])
            ->one();

        if ($message === null) {
            throw new NotFoundHttpException('Сообщение не найдено');
        }

        return $message;
    }

    /**
     * Создает новое сообщение через форму
     */
    public static function createByFrom(MessageForm $messageForm)
    {
        $message = new Message();
        $message->attributes = $messageForm->attributes;
        $message->ip = filter_var(Yii::$app->request->userIP, FILTER_VALIDATE_IP) ?: '0.0.0.0';
        $message->link = self::gnerateUniqueLink($message);
        $message->status = Message::STATUS_ACTIVE;
        $message->save(); // Отработает событие и запустит email отправку
    }

    /**
     * Создать уникальную ссылку
     */
    private static function gnerateUniqueLink(Message $message)
    {
        return md5(uniqid() . Yii::$app->security->generateRandomString(10)) . md5($message->email);
    }

    /**
     * Получить сообщения с пагинацией
     *
     * @return array
     */
    public static function getMessagesWithPagination(int $pageSize = 10)
    {
        $subQuery = Message::find()
            ->select(['ip', 'COUNT(*) as post_count'])
            ->where(['status' => Message::STATUS_ACTIVE])
            ->groupBy('ip');

        $query = Message::find()
            ->select(['message.*', 'postsCount' => 'post_count'])
            ->leftJoin(['post_counts' => $subQuery], 'post_counts.ip = message.ip')
            ->where(['message.status' => Message::STATUS_ACTIVE])
            ->orderBy(['message.created_at' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $pageSize,
            'pageSizeParam' => false,
        ]);
        $messages = $query->offset($pages->offset)->limit($pages->limit)->all();

        return [
            'messages' => $messages,
            'pages' => $pages,
        ];
    }
}
