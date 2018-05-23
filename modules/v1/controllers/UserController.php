<?php

namespace app\modules\v1\controllers;

use app\common\components\Jwt;
use app\common\controllers\ApiController;
use app\modules\v1\models\TokenResource;
use app\modules\v1\models\UserResource;
use Lcobucci\JWT\Token;
use tuyakhov\jsonapi\tests\data\ResourceModel;
use Yii;
use yii\di\Instance;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class UserController extends ApiController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'][] = 'token';

        return $behaviors;
    }

    /**
     * @return TokenResource
     * @throws BadRequestHttpException
     * @throws UnauthorizedHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionToken()
    {
        $request = Yii::$app->getRequest();
        $data = $request->getBodyParams();

        /**
         * Input data validation
         */
        if (empty($data['User'])) {
            throw new BadRequestHttpException();
        }

        $data = $data['User'];
        if (empty($data['login'])) {
            throw new BadRequestHttpException();
        }

        if (empty($data['password'])) {
            throw new BadRequestHttpException();
        }

        $user = UserResource::findOne(['login' => $data['login']]);
        if (empty($user)) {
            throw new UnauthorizedHttpException();
        }

        if (!Yii::$app->getSecurity()->validatePassword($data['password'], $user->password)) {
            throw new UnauthorizedHttpException();
        }

        /**
         * @var Jwt $jwt
         */
        $jwt = Instance::ensure('jwt', Jwt::class);
        /**
         * @var Token $token
         */
        $token = $jwt->createToken($user);

        $resource = new TokenResource();
        $resource->token = (string)$token;
        $resource->expired = $token->getClaim('exp', 0);
        $resource->setResourceRelationship('user', $user);

        return $resource;
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