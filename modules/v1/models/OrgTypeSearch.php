<?php

namespace app\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class OrgTypeSearch extends Model
{

    public $filter;

    public $sort;

    public $page;

    public function rules()
    {
        return [
          [['filter', 'sort', 'page'], 'safe'],
        ];
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (!empty($params) && array_diff(array_keys($params),
            [[], 'filter', 'sort', 'page'])) {
            throw new BadRequestHttpException('Invalid get parameters.');
        }


        if (!is_array($params['filter']) || array_diff(array_keys($params['filter']),
            ['name', 'description'])) {
            throw new BadRequestHttpException('Invalid attribute for get parameter: filter');
        }

        $page = $params['page'];
        $limit = isset($page['limit']) ? $page['limit'] : 10;
        $offset = isset($page['offset']) ? $page['offset'] : 0;

        /* if($params['sort'] && array_diff(array_keys($params['sort']), ['name', 'description'] ) ){
           throw new BadRequestHttpException('Invalid attribute for get parameter: sort');
         }*/

        $sort_name = SORT_ASC;
        $sort_descr = SORT_ASC;
        if ($params['sort']) {
            if (substr_count($params['sort'], 'name')) {
                $sort_name = substr($params['sort'], 0,
                  1) === '-' ? SORT_DESC : SORT_ASC;
            } elseif (substr_count($params['sort'], 'description')) {
                $sort_descr = substr($params['sort'], 0,
                  1) === '-' ? SORT_DESC : SORT_ASC;
            } else {
                throw new BadRequestHttpException('Invalid value for get parameter: sort');
            }
        }

        $query = OrgTypeResource::find();

        $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
            'pageSize' => $limit,
            'page' => $offset,
          ],
          'sort' => [
            'defaultOrder' => [
              'name' => $sort_name,
              'description' => $sort_descr,
            ],
          ],
        ]);

        if (empty($params)) {
            return $dataProvider;
        }

        $this->load($params, '');

        if (!$this->validate()) {
            throw new BadRequestHttpException(implode($this->getErrorSummary(1)));
        }
        if ($params['filter']) {
            foreach ($params['filter'] as $field => $value) {
                $query->andFilterWhere(['ilike', $field, $value]);
            }
        }

        return $dataProvider;
    }
}