<?php

namespace app\validators;

use app\models\Message;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\validators\Validator;

class TimeLimitValidator extends Validator
{
    private $timeInterval = 180; // 3 минуты

    /**
     * @param Model $model
     * @param string $attribute
     * @throws InvalidConfigException
     */
    public function validateAttribute($model, $attribute)
    {
        $lastMessage = Message::find()
            ->where(['ip' => Yii::$app->request->userIP])
            ->andWhere(['>=', 'created_at', time() - $this->timeInterval])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if ($lastMessage) {
            $nextTime = $lastMessage->created_at + $this->timeInterval;
            $timeLeft = $nextTime - time();

            if ($timeLeft > 0) {
                $minutes = floor($timeLeft / 60);
                $seconds = $timeLeft % 60;

                $this->addError($model, $attribute,
                    "Вы можете отправить следующее сообщение через {$minutes} мин. {$seconds} сек. " .
                    "В " . Yii::$app->formatter->asTime($nextTime, 'H:i') . ")"
                );
            }
        }
    }
}
