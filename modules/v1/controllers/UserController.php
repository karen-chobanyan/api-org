<?php

namespace app\modules\v1\controllers;

use app\common\components\Jwt;
use app\common\controllers\ApiController;
use app\common\models\UserModel;
use app\modules\v1\models\UserResource;
use tuyakhov\jsonapi\tests\data\ResourceModel;
use yii\di\Instance;
use yii\web\NotFoundHttpException;

class UserController extends ApiController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'][] = 'index';

        return $behaviors;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $user = UserModel::findOne(1);
        $token = null;
        if (!empty($user)) {
            $jwt = Instance::ensure('jwt', Jwt::class);
            $token = $jwt->createToken($user);
        }



        $str_token = (string) $token;

        $token = $jwt->loadToken($str_token);

        return ['token' => $str_token, 'uid' => $token->getClaim('uid')];
    }

    /**
     * @param $id
     * @return null|UserResource
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!empty($id)) {
            $resource = UserResource::findOne($id);

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