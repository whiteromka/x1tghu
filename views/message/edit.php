<?php

/** @var yii\web\View $this */
/** @var Message $message */
/** @var MessageForm $messageForm */
/** @var ActiveForm $form */

use app\models\forms\MessageForm;
use app\models\Message;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<div>
    <div class="body-content">
        <div class="row">
            <div class="col-md-5 col-lg-4">
                <h2>Форма:</h2>
                <?php $form = ActiveForm::begin(['id' => 'message-form']); ?>
                <?= $form->field($messageForm, 'name')->textInput(['readonly' => true, 'value' => $message->name]) ?>
                <?= $form->field($messageForm, 'email')->textInput(['readonly' => true, 'value' => $message->email]) ?>
                <?= $form->field($messageForm, 'text')->textarea(['rows' => 8, 'value' => $message->text])->label('Текст сообщения') ?>
                <div class="form-group">
                    <?= Html::submitButton('Отредактировать', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
