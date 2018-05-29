<?php

namespace app\common\models;

use yii\db\ActiveRecord;

/**
 * OrgType model
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * */
class OrgTypeModel extends ActiveRecord implements OrgTypeInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['name'], 'required'],
          ['name', 'string', 'max' => 50],
          ['description', 'string', 'max' => 255],
        ];
    }

    /**
     * Returns an ID that can uniquely identify a type of organistion.
     *
     * @return string|int an ID that uniquely identifies a type of organistion.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns name of a type of organistion.
     *
     * @return string name a type of organistion.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns description of a type of organistion.
     *
     * @return string description of a type of organistion.
     */
    public function getDescription()
    {
        return $this->description;
    }
}