<?php

namespace app\models\forms;

use app\validators\TimeLimitValidator;
use yii\base\Model;

class MessageForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /** @var string */
    public $name;

    /** @var string */
    public $email;

    /** @var string */
    public $text;

    /** @var string */
    public $captcha;

    public function rules()
    {
        return [
            [['name', 'email', 'text', 'captcha'], 'required'],
            [['name', 'email', 'text'], 'trim'],
            ['email', 'email'],
            ['text', 'string', 'min' => 5, 'max' => 1000],
            ['name', 'string', 'min' => 2, 'max' => 15],
            ['text', TimeLimitValidator::class],
            ['captcha', 'captcha', 'captchaAction' => 'message/captcha'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'email', 'text', 'captcha'],
            self::SCENARIO_UPDATE => ['text'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'text' => 'Текст сообщения',
            'captcha' => 'Проверочный код',
        ];
    }
}
