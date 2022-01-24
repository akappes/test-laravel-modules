<?php


namespace Modules\Fruit\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Fruit\Entities\Fruit;

/**
 * Class FruitTransformer
 *
 * @package Modules\Fruit\Transformers
 */
class FruitTransformer extends TransformerAbstract
{

    /**
     * @param Fruit $fruit
     * @return array<string, mixed>
     */
    public function transform(Fruit $fruit)
    {
        return [
            'id' => (int)$fruit->id,
            'name' => $fruit->name,
            'price' => (float)$fruit->price,
            'expiration_at' => $fruit->expiration_at,
        ];
    }
}
