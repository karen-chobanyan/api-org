<?php

namespace app\modules\v1\controllers;

use app\common\components\Jwt;
use app\common\controllers\ApiController;
use app\modules\v1\models\OrganizationResource;
use tuyakhov\jsonapi\tests\data\ResourceModel;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\modules\v1\models\OrganizationsSearch;
use yii\web\Response;

class OrganizationsController extends ApiController
{
    /**
     * {@inheritdoc}
     */
    public function actionIndex(){
        $request = Yii::$app->getRequest();
        $params = $request->queryParams;
        $modelSearch = new OrganizationsSearch();
        $res = $modelSearch->search($params);
        return $res;
    }

    /**
     * @param $id
     * @return null|OrganizationResource
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!empty($id)) {
            $resource = OrganizationResource::findOne($id);
            $orgType = $resource->orgtype;
            $resource->setResourceRelationship('orgtype', $orgType);
            return $resource;
        }

        throw new NotFoundHttpException();
    }


    /**
     * @return OrganizationResource
     * @throws HttpException
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = Yii::$app->getRequest()->getBodyParams();
            $orgResource = new OrganizationResource;
            $orgResource->load( $data['Organization'], '' );
            if ($orgResource->validate() && $orgResource->save()) {
                return $orgResource;
            } else {
                throw new HttpException( 422, json_encode( $orgResource->errors ) );
            }
        }

    }

    /**
     * @param $id
     * @return OrganizationResource|null
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        if ($request->isPut) {
            $orgResource = OrganizationResource::findOne( $id );
            if (!$orgResource) {
                throw new NotFoundHttpException();
            }
            $data = Yii::$app->getRequest()->getBodyParams();
            $orgResource->load( $data['Organization'], '' );
            if ($orgResource->validate() && $orgResource->save()) {
                return $orgResource;
            } else {
                throw new HttpException( 422, json_encode( $orgResource->errors ) );
            }
        }
    }


    /**
     * @param $id
     * @return \yii\console\Response|Response
     * @throws NotFoundHttpException
     * @throws Yii\web\ServerErrorHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        if ($request->isDelete) {
            $orgResource = OrganizationResource::findOne( $id );
            if (!$orgResource) {
                throw new NotFoundHttpException();
            }

            if ($orgResource->delete()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode( 204 );
                return $response;
            } else {
                throw new yii\web\ServerErrorHttpException( 'Ошибка сервера при удалении типа организации.' );
            }
        }
    }

}