<?php

namespace app\modules\v1\controllers;

use app\common\components\Jwt;
use app\common\controllers\ApiController;
use app\common\models\User;
use tuyakhov\jsonapi\tests\data\ResourceModel;
use yii\di\Instance;

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
        $user = User::findOne(1);
        $token = null;
        if (!empty($user)) {
            $jwt = Instance::ensure('jwt', Jwt::class);
            $token = $jwt->createToken($user);
        }



        $str_token = (string) $token;

        $token = $jwt->loadToken($str_token);

        return ['token' => $str_token, 'uid' => $token->getClaim('uid')];
    }

    public function actionTest()
    {
        return new ResourceModel();
    }

}