<?php

namespace app\common\models;


interface OrgTypeInterface
{

    /**
     * Returns an ID that can uniquely identify a type of organistion.
     *
     * @return string|int an ID that uniquely identifies a type of organistion.
     */
    public function getId();

    /**
     * Returns name of a type of organistion.
     *
     * @return string name a type of organistion.
     */
    public function getName();

    /**
     * Returns description of a type of organistion.
     *
     * @return string description of a type of organistion.
     */
    public function getDescription();


}