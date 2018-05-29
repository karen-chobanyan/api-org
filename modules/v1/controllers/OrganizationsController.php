<?php

namespace app\modules\v1\controllers;

use app\common\components\Jwt;
use app\common\controllers\ApiController;
use app\modules\v1\models\OrganizationsResource;
use Lcobucci\JWT\Token;
use tuyakhov\jsonapi\tests\data\ResourceModel;
use Yii;
use yii\di\Instance;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class OrganizationsController extends ApiController
{
    /**
     * {@inheritdoc}
     */
    // public function behaviors()
    // {
    //     $behaviors = parent::behaviors();
    //     // $behaviors['authenticator']['except'][] = 'token';

    //     return $behaviors;
    // }

    public function actionIndex(){
        $resource = OrganizationsResource::find()->all();

        if (!empty($resource)) {
            return $resource;
        } 
        
        throw new NotFoundHttpException();
    }

    /**
     * @param $id
     * @return null|OrganizationsResource
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!empty($id)) {
            $resource = OrganizationsResource::findOne($id);

            if (!empty($resource)) {
                return $resource;
            }
        }

        throw new NotFoundHttpException();
    }

    public function actionTest()
    {
        return new ResourceModel();
    }

}