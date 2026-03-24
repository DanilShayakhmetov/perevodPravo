<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "translator_schedule".
 *
 * @property int $id
 * @property int $translator_id
 * @property int $day_of_week
 * @property int|null $is_working
 *
 * @property Translator $translator
 */
class TranslatorSchedule extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translator_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_working'], 'default', 'value' => 1],
            [['translator_id', 'day_of_week'], 'required'],
            [['translator_id', 'day_of_week', 'is_working'], 'integer'],
            [['translator_id', 'day_of_week'], 'unique', 'targetAttribute' => ['translator_id', 'day_of_week']],
            [['translator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Translator::class, 'targetAttribute' => ['translator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'translator_id' => 'Translator ID',
            'day_of_week' => 'Day Of Week',
            'is_working' => 'Is Working',
        ];
    }

    /**
     * Gets query for [[Translator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslator()
    {
        return $this->hasOne(Translator::class, ['id' => 'translator_id']);
    }

}
