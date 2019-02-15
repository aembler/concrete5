<?php
namespace Concrete\Core\Api\Resource;

use League\Fractal\TransformerAbstract;

interface TransformableInterface
{

    /**
     * @return TransformerAbstract
     */
    public function getTransformer();

}