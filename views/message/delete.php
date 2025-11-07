<?php

/** @var yii\web\View $this */
/** @var Message $message */

use app\models\Message;
use yii\helpers\Html;

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
            <div class="card">
                <div class="card-body">
                    <h5>Вы уверены, что хотите удалить это сообщение?</h5>
                    <div class="card mb-4">
                        <div class="card-body">
                            <p><strong>Автор:</strong> <?= Html::encode($message->name) ?></p>
                            <p><strong>Email:</strong> <?= Html::encode($message->email) ?></p>
                            <p><strong>Текст:</strong></p>
                            <div class="bg-light p-3 rounded">
                                <?= \yii\helpers\HtmlPurifier::process($message->text) ?>
                            </div>
                        </div>
                    </div>
                    <?= Html::beginForm(['delete-confirm', 'link' => $message->link], 'post', ['class' => 'text-center']) ?>
                        <div class="form-group">
                            <?= Html::submitButton('Удалить сообщение', [
                                'class' => 'btn btn-danger btn-lg',
                                'onclick' => 'return confirm("Вы точно уверены? Это действие необратимо.")'
                            ]) ?>
                        </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>
</div>
