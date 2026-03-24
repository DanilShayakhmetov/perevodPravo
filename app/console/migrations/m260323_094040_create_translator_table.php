<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translator}}`.
 */
class m260323_094040_create_translator_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('translator', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'language' => $this->string(10)->notNull(),
            'is_busy' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->batchInsert('translator', ['id', 'name', 'language', 'is_busy'], [
            [1, 'Ivan Ivanov', 'en', 0],
            [2, 'Maria Petrova', 'de', 1],
            [3, 'John Smith', 'fr', 0],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('translator');
    }
}
