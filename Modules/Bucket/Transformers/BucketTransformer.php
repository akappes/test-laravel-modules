<?php


namespace Modules\Bucket\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Bucket\Entities\Bucket;
use Modules\Fruit\Entities\Fruit;
use Modules\Fruit\Transformers\FruitTransformer;
use Spatie\Fractalistic\ArraySerializer;

/**
 * Class BucketTransformer
 *
 * @package Modules\Bucket\Transformers
 */
class BucketTransformer extends TransformerAbstract
{

    /**
     * @param Bucket $bucket
     * @return array<string, mixed>
     */
    public function transform(Bucket $bucket)
    {
        return [
            'id' => (int)$bucket->id,
            'name' => $bucket->name,
            'capacity' => (int)$bucket->capacity,
            'occupation' => ($bucket->fruits_count * 100)/$bucket->capacity . "%",
            'total_value' => (float) $bucket->fruits_sum_price,
            'fruits' => $bucket->fruits ? $this->fruitTransform($bucket->fruits) : null
        ];
    }

    /**
     * @param $fruits
     * @return array
     */
    protected function fruitTransform($fruits): array
    {
        $fractal = fractal()->serializeWith(ArraySerializer::class);
        $fractal->collection($fruits, FruitTransformer::class);
        return $fractal->toArray();
    }
}
