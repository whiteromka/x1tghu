<?php

use yii\db\Migration;

class m251105_175141_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name'=> $this->string(15)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'ip' => $this->string()->notNull(),
            'created_at' =>  $this->bigInteger()->unsigned()->null(),
            'updated_at' =>  $this->bigInteger()->unsigned()->null(),
        ]);

        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer()->notNull(),
            'text' => $this->string(1000)->notNull(),
            'link' => $this->string(250)->notNull()->comment('Ссылка на редактирование сообщения'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Статус: 1 активна, 2 удалена'),
            'created_at' => $this->bigInteger()->unsigned()->null(),
            'updated_at' => $this->bigInteger()->unsigned()->null(),
        ]);

        $this->createIndex('idx_message__user_id', '{{%message}}', 'user_id');

        $this->addForeignKey(
            'fk_message__user_id',
            '{{%message}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_message__user_id', '{{%message}}');
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%user}}');
    }
}
