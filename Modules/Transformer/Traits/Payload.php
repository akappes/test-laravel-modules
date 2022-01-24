<?php

namespace Modules\Transformer\Traits;

use Illuminate\Support\Arr;

/**
 * Trait Payload
 *
 * @package Modules\Transformer\Traits
 */
trait Payload
{

    /**
     * @param array $payload
     *
     * @return array
     */
    public function convertToPayload(array $payload): array
    {
        $attributes = [];
        foreach ($this->translator() as $key => $value) {
            $attribute = Arr::get($payload, $key);
            if ($attribute) {
                $attributes[$value] = $attribute;
            }
        }

        return $attributes;
    }
}
