<?php

namespace app\modules\v1\controllers;


use app\common\controllers\ApiController;
use app\modules\v1\models\OrgTypeResource;
use app\modules\v1\models\OrgTypeSearch;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class OrgTypesController extends ApiController
{

    /**
     * @param $id
     *
     * @return null|OrgTypeResource
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!empty($id)) {
            $resource = OrgTypeResource::findOne($id);

            if (!empty($resource)) {
                return $resource;
            }
        }

        throw new NotFoundHttpException('Тип организации с указанным ID не найден.');
    }

    public function actionCreate()
    {
        $data = Yii::$app->getRequest()->getBodyParams();
        $orgType = new OrgTypeResource();
        $orgType->load($data['OrgType'], '');
        if ($orgType->validate() && $orgType->save()) {
            return $orgType;
        } else {
            throw new HttpException(422, json_encode($orgType->errors));
        }

    }

    public function actionUpdate($id)
    {
        $orgType = OrgTypeResource::findOne($id);
        if (!$orgType) {
            throw new NotFoundHttpException();
        }

        $data = Yii::$app->getRequest()->getBodyParams();
        $orgType->load($data['OrgType'], '');
        if ($orgType->validate() && $orgType->save()) {
            return $orgType;
        } else {
            throw new HttpException(422, json_encode($orgType->errors));
        }
    }

    public function actionDelete($id)
    {
        $orgType = OrgTypeResource::findOne($id);
        if (!$orgType) {
            throw new NotFoundHttpException();
        }

        if ($orgType->delete()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(204);
            return $response;
        } else {
            throw new yii\web\ServerErrorHttpException('Ошибка сервера при удалении типа организации.');
        }
    }

    public function actionIndex()
    {
        $request = Yii::$app->getRequest();
        $params = $request->queryParams;
        $modelSearch = new OrgTypeSearch();
        $res = $modelSearch->search($params);
        return $res;
    }

}