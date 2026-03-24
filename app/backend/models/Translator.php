<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "translator".
 *
 * @property int $id
 * @property string $name
 * @property string $language
 * @property int|null $is_busy
 * @property string|null $created_at
 *
 * @property TranslatorSchedule[] $translatorSchedules
 */
class Translator extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_busy'], 'default', 'value' => 0],
            [['name', 'language'], 'required'],
            [['is_busy'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'language' => 'Language',
            'is_busy' => 'Is Busy',
            'created_at' => 'Created At',
        ];
    }

    public function getSchedules()
    {
        return $this->hasMany(TranslatorSchedule::class, ['translator_id' => 'id']);
    }

}
