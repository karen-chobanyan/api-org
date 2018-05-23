<?php

namespace app\common\components;


class Serializer extends \tuyakhov\jsonapi\Serializer
{
    /**
     * Fixed bag in serialisation.
     *
     * @param array|\tuyakhov\jsonapi\ResourceInterface $resources
     * @param array $included
     * @param bool $assoc
     * @return array
     */
    protected function serializeIncluded($resources, array $included = [], $assoc = false)
    {
        if (empty($included)) {
            return [];
        }

        return parent::serializeIncluded($resources, $included, $assoc);
    }

}