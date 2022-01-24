<?php

namespace Modules\Fruit\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Carbon;

class ExpirationScope implements Scope
{
    public function apply(Builder $builder, Model $model) {
        $builder->where('expiration_at', '>=', Carbon::now()->format('Y-m-d'));
    }
}
