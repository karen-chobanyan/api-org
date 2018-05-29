<?php

namespace app\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class OrganizationsSearch extends Model
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
        if (!empty($params['name'])) {
            if (!empty($params) && array_diff(array_keys($params),
                [[], 'filter', 'sort', 'page'])) {
                throw new BadRequestHttpException('Invalid get parameters.');
            }
        }
        
        if (!empty($params['filter'])) {
            if (!is_array($params['filter']) || array_diff(array_keys($params['filter']),
                ['name', 'description'])) {
                throw new BadRequestHttpException('Invalid attribute for get parameter: filter');
            }
        }

        if (empty($params['page'])) {
            $params['page'] =  ['limit' => 10, 'offset' => 0];
        }

        if (empty($params['sort'])) {
            $params['sort'] = 'name';
        }


        $page = $params['page'];
        $limit = isset($page['limit']) ? $page['limit'] : 10;
        $offset = isset($page['offset']) ? $page['offset'] : 0;

        $sort_name = SORT_ASC;
        if ($params['sort']) {
            if (substr_count($params['sort'], 'name')) {
                $sort_name = substr($params['sort'], 0,
                  1) === '-' ? SORT_DESC : SORT_ASC;
            } else {
                throw new BadRequestHttpException('Invalid value for get parameter: sort');
            }
        }

        $query = OrganizationsResource::find();
        $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
            'pageSize' => $limit,
            'page' => $offset,
          ],
          'sort' => [
            'defaultOrder' => [
              'name' => $sort_name
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
        if (!empty($params['filter'])) {
            foreach ($params['filter'] as $field => $value) {
                $query->andFilterWhere(['ilike', $field, $value]);
            }
        }

        return $dataProvider;
    }
}