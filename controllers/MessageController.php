<?php

namespace app\controllers;

use app\models\forms\MessageForm;
use app\models\Message;
use app\services\MessageService;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\LoginForm;
use app\models\ContactForm;
use Yii;

class MessageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'edit' => ['GET', 'POST'],
                    'delete' => ['POST'],
                    'delete-confirm' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $messageForm = new MessageForm(['scenario' => MessageForm::SCENARIO_CREATE]);
        if ($messageForm->load(Yii::$app->request->post()) && $messageForm->validate()) {
            MessageService::createByFrom($messageForm);
            Yii::$app->session->setFlash('success', 'Сообщение было успешно добавлено!');
            return $this->refresh();
        }

        $dataMessages = MessageService::getMessagesWithPagination();

        return $this->render('index', [
            'messageForm' => $messageForm,
            'messages' => $dataMessages['messages'],
            'pages' => $dataMessages['pages'],
        ]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionEdit(string $link)
    {
        $message = MessageService::getActiveByLinkOrException($link);

        $messageForm = new MessageForm(['scenario' => MessageForm::SCENARIO_UPDATE]);
        if ($messageForm->load(Yii::$app->request->post()) && $messageForm->validate()) {
            if (!$message->canEdit()) {
                Yii::$app->session->setFlash('error', 'Время редактирования истекло. Редактирование доступно в течение 12 часов после отправки.');
                return $this->redirect(['index']);
            }
            $message->text = $messageForm->text;
            if ($message->save()) {
                Yii::$app->session->setFlash('success', 'Сообщение было успешно обновлено!');
                return $this->redirect(['index']);
            }

        }

        return $this->render('edit', [
            'message' => $message,
            'messageForm' => $messageForm,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDelete(string $link)
    {
        $message = MessageService::getActiveByLinkOrException($link);

        if (!$message->canDelete()) {
            Yii::$app->session->setFlash('error', 'Время удаления истекло. Удаление доступно в течение 14 дней после отправки.');
            return $this->redirect(['index']);
        }

        return $this->render('delete', [
            'message' => $message,
        ]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionDeleteConfirm(string $link)
    {
        $message = MessageService::getActiveByLinkOrException($link);

        if (!$message->canDelete()) {
            Yii::$app->session->setFlash('error', 'Время удаления истекло.');
            return $this->redirect(['index']);
        }

        $message->status = Message::STATUS_DELETED;
        $message->save();
        Yii::$app->session->setFlash('success', 'Сообщение успешно удалено.');

        return $this->redirect(['index']);
    }
}
