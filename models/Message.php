<?php

namespace app\models;

use app\helpers\HtmlPurifierHelper;
use app\services\EmailService;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $ip
 * @property string $text
 * @property string $link Ссылка на редактирование сообщения
 * @property int $status Статус: 1 активна, 0 удалена
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Message extends ActiveRecord
{
    private const TIME_EDIT = 43200; // 12 часов
    private const TIME_DELETE = 1209600; // 14 дней
    public const STATUS_ACTIVE = 1;
    public const STATUS_DELETED = 0;

    /** @var int Виртуальное свойство для вывода кол-ва всех постов */
    public $postsCount;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'sendEmailNotification']);
    }

    public function sendEmailNotification($event)
    {
        if ($this->status === self::STATUS_ACTIVE) {
            EmailService::sendMessageLinks($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['name', 'email', 'ip', 'text', 'link'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['ip', 'email'], 'string'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['name'], 'string', 'min' => 2, 'max' => 15],
            [['text'], 'string', 'min' => 5, 'max' => 1000],
            [
                'text',
                'filter',
                'filter' => function($value) {
                    return (new HtmlPurifierHelper())->purify($value);
                }
            ],
        ];
    }

    /**
     * Можно ли редактировать сейчас
     */
    public function canEdit(): bool
    {
        return (time() - $this->created_at) < self::TIME_EDIT;
    }

    /**
     * Можно ли удалить сейчас
     */
    public function canDelete(): bool
    {
        return (time() - $this->created_at) < self::TIME_DELETE;
    }
}
