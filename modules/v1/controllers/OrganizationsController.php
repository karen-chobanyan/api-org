<?php

namespace app\modules\v1\controllers;

use app\common\components\Jwt;
use app\common\controllers\ApiController;
use app\modules\v1\models\OrganizationsResource;
use tuyakhov\jsonapi\tests\data\ResourceModel;
use Yii;
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
     * @return null|OrganizationsResource
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!empty($id)) {
            $resource = OrganizationsResource::findOne($id);

            $orgType = $resource->orgtype;

                $resource->setResourceRelationship('orgtype', $orgType);
                return $resource;

        }

        throw new NotFoundHttpException();
    }

}