<?php

namespace app\modules\v1\models;


use app\common\models\OrgTypeModel;
use tuyakhov\jsonapi\LinksInterface;
use tuyakhov\jsonapi\ResourceIdentifierInterface;
use tuyakhov\jsonapi\ResourceInterface;
use tuyakhov\jsonapi\ResourceTrait;
use yii\helpers\Url;
use yii\web\Link;
use yii\helpers\Inflector;

class OrgTypeResource extends OrgTypeModel implements ResourceInterface, LinksInterface
{

    use ResourceTrait;

    /**
     * @var array
     */
    protected $excludedFields = ['id'];

    /**
     * The "type" member of a resource object.
     *
     * @return string a type that identifies the resource.
     */
    public function getType()
    {
        return 'OrgType';
    }

    /**
     * The "attributes" member of the resource object representing some of the
     * resource’s data.
     *
     * @param array $fields specific fields that a client has requested.
     *
     * @return array an array of attributes that represent information about
     *   the resource object in which it’s defined.
     */
    public function getResourceAttributes(array $fields = [])
    {
        $attributes = array_diff($this->fields(), $this->excludedFields);

        foreach ($attributes as $key => $attribute) {
            $attribute = Inflector::camel2id(Inflector::variablize($attribute),
              '_');

            if (!empty($fields) && !in_array($attribute, $fields, true)) {
                unset($attributes[$key]);
            } else {
                $attributes[$key] = $this->$attribute;
            }
        }

        return $attributes;
    }

    /**
     * The "relationships" member of the resource object describing
     * relationships between the resource and other JSON API resources.
     *
     * @param array $linked specific resource linkage that a client has
     *   requested.
     *
     * @return ResourceIdentifierInterface[] represent references from the
     *   resource object in which it’s defined to other resource objects.
     */
    public function getResourceRelationships(array $linked = [])
    {
        return [];
    }

    public function setResourceRelationship($name, $relationship)
    {
    }

    public function getRelationshipLinks($name)
    {
        $primaryLinks = $this->getLinks();
        if (!array_key_exists(Link::REL_SELF, $primaryLinks)) {
            return [];
        }

        $resourceLink = is_string($primaryLinks[Link::REL_SELF]) ? rtrim($primaryLinks[Link::REL_SELF],
          '/') : null;
        if (!$resourceLink) {
            return [];
        }

        return [
          Link::REL_SELF => "{$resourceLink}/relationships/{$name}",
          'related' => "{$resourceLink}/{$name}",
        ];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
          Link::REL_SELF => Url::to(Url::base(true) . '/v1/org-types/' . $this->getId()),
        ];
    }
}