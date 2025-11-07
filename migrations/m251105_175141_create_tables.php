<?php

use yii\db\Migration;

class m251105_175141_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'name'=> $this->string(15)->notNull(),
            'email'=> $this->string()->notNull(),
            'ip'=> $this->string()->notNull(),
            'text' => $this->string(1000)->notNull(),
            'link' => $this->string()->notNull()->comment('Ссылка на редактирование сообщения'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Статус: 1 активна, 0 удалена'),
            'created_at' => $this->bigInteger()->unsigned()->null(),
            'updated_at' => $this->bigInteger()->unsigned()->null(),
        ]);

        $this->createIndex('idx_message_ip', '{{%message}}', 'ip');
        $this->createIndex('idx_message_link_status', '{{%message}}', ['link', 'status']);
        $this->createIndex('idx_message_created_at', '{{%message}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
