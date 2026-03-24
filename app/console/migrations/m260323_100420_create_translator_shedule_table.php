<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translator_shedule}}`.
 */
class m260323_100420_create_translator_shedule_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('translator_schedule', [
            'id' => $this->primaryKey(),
            'translator_id' => $this->integer()->notNull(),
            'day_of_week' => $this->tinyInteger()->notNull(), // 1-7
            'is_working' => $this->boolean()->defaultValue(true),
        ]);

        // FK
        $this->addForeignKey(
            'fk_schedule_translator',
            'translator_schedule',
            'translator_id',
            'translator',
            'id',
            'CASCADE'
        );

        // Уникальность: один день = одна запись
        $this->createIndex(
            'uniq_translator_day',
            'translator_schedule',
            ['translator_id', 'day_of_week'],
            true
        );

        $this->batchInsert('translator_schedule', [
            'translator_id',
            'day_of_week',
            'is_working'
        ], [
            // Ivan (будни)
            [1, 1, 1],
            [1, 2, 1],
            [1, 3, 1],
            [1, 4, 1],
            [1, 5, 1],

            // Maria (выходные)
            [2, 6, 1],
            [2, 7, 1],

            // John (все дни)
            [3, 1, 1],
            [3, 2, 1],
            [3, 3, 1],
            [3, 4, 1],
            [3, 5, 1],
            [3, 6, 1],
            [3, 7, 1],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('translator_schedule');
    }
}
