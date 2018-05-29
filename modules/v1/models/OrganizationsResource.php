<?php


namespace app\modules\v1\models;


use app\common\models\OrganizationsModel;
use tuyakhov\jsonapi\LinksInterface;
use tuyakhov\jsonapi\ResourceInterface;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\Link;

/**
 * Class OrganizationsResource
 * @package app\modules\v1\models
 *
 * @property array $links
 * @property string $type
 */
class OrganizationsResource extends OrganizationsModel implements ResourceInterface, LinksInterface
{

    /**
     * @var array
     */
    protected $excludedFields = [];
    protected $relationships = [];

    /**
     * @return string
     */
    public function getType()
    {
        return 'organization';
    }

    /**
     * @param array $fields
     * @return array
     */
    public function getResourceAttributes(array $fields = [])
    {
        $attributes = array_diff($this->fields(), $this->excludedFields);

        foreach ($attributes as $key => $attribute) {
            $attribute = Inflector::camel2id(Inflector::variablize($attribute), '_');

            if (!empty($fields) && !in_array($attribute, $fields, true)) {
                unset($attributes[$key]);
            } else {
                $attributes[$key] = $this->$attribute;
            }
        }

        return $attributes;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(Url::base(true).'/v1/organizations/'.$this->getId())
        ];
    }

    /**
     * @param $name
     * @return array
     */
    public function getRelationshipLinks($name)
    {
        return [];
    }

    /**
     * @param array $linked
     * @return array|\tuyakhov\jsonapi\ResourceIdentifierInterface[]
     */
    public function getResourceRelationships(array $linked = [])
    {
        return $this->relationships;
    }

    /**
     * @param $name
     * @param $relationship
     */
    public function setResourceRelationship($name, $relationship)
    {
        $this->relationships[$name] = $relationship;
        return $this;
    }

}