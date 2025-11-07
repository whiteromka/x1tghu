<?php

/** @var yii\web\View $this */
/** @var Message[] $messages */
/** @var MessageForm $messageForm */
/** @var ActiveForm $form */
/** @var Pagination $pages */

use app\helpers\IpHelper;
use app\helpers\RuHelper;
use app\models\forms\MessageForm;
use app\models\Message;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\LinkPager;
use yii\captcha\Captcha;
use yii\data\Pagination;
use yii\helpers\Html;

?>
<div>
    <div class="body-content">
        <div class="row">
            <div class="col-md-7 col-lg-8">
                <h2>Сообщения пользователей:</h2>
                <?php foreach ($messages as $message) :?>
                <div class="card card-default">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($message->name)?></h5>
                        <p><?= \yii\helpers\HtmlPurifier::process($message->text) ?></p>
                        <p>
                            <small class="text-muted">
                                <?= Yii::$app->formatter->asRelativeTime($message->created_at) ?> |
                                <?= IpHelper::maskIp($message->ip) ?> |
                                <?= RuHelper::postsCount($message->postsCount) ?>
                            </small>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="col-md-5 col-lg-4">
                <h2>Форма:</h2>
                <?php $form = ActiveForm::begin(['id' => 'message-form']); ?>
                <?= $form->field($messageForm, 'name') ?>
                <?= $form->field($messageForm, 'email') ?>
                <?= $form->field($messageForm, 'text')->textarea(['rows' => 8]) ?>
                <?= $form->field($messageForm, 'captcha')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    'captchaAction' => 'message/captcha',
                ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="row m-5">
            <div class="col-sm-12 ">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'options' => ['class' => 'pagination justify-content-center']
                ]) ?>
            </div>
        </div>

    </div>
</div>
