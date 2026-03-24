<?php

namespace backend\controllers;

use app\models\Translator;
use yii\web\Controller;
use yii\web\Response;


class TranslatorController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $response = \Yii::$app->response;

        // CORS заголовки
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', '*');

        // Обработка preflight (OPTIONS)
        if (\Yii::$app->request->isOptions) {
            $response->statusCode = 200;
            return false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return Translator::find()
            ->with('schedules')
            ->asArray()
            ->all();
    }

    public function actionAvailable($day)
    {
        $translators = Translator::find()
            ->alias('t')
            ->joinWith('schedules s')
            ->where([
                't.is_busy' => 0,
                's.day_of_week' => $day,
                's.is_working' => 1
            ])
            ->asArray()
            ->all();

        if ($translators) {
            return [
                'status' => 'ok',
                'data' => $translators
            ];
        }

        return [
            'status' => 'empty',
            'message' => 'Нет свободных переводчиков'
        ];
    }
}