<?php


namespace Modules\Transformer\Facades;

use Modules\Transformer\Entities\FractalBuilder as Builder;
use Illuminate\Support\Facades\Facade;

class FractalBuilder extends Facade
{
    public static function getFacadeAccessor()
    {
        return app(Builder::class);
    }

}
