<?php


namespace Modules\Bucket\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Bucket\Entities\Bucket;
use Modules\Fruit\Entities\Fruit;

/**
 * Class BucketTransformer
 *
 * @package Modules\Bucket\Transformers
 */
class BucketTransformer extends TransformerAbstract
{

    /**
     * @param Bucket $fruit
     * @return array<string, mixed>
     */
    public function transform(Bucket $bucket)
    {
        return [
            'id' => (int)$bucket->id,
            'name' => $bucket->name,
            'capacity' => (int)$bucket->capacity,
        ];
    }
}
