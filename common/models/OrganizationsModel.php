<?php

namespace app\common\models;


use Lcobucci\JWT\Token;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class OrganizationsModel extends ActiveRecord 
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizations';
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }


}