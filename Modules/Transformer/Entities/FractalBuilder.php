<?php

namespace Modules\Transformer\Entities;

use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractal\Fractal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;

class FractalBuilder
{

    /**
     * Transforma o recurso com o transformador especificado.
     * Reconhece itens e coleções simples e paginadas.
     *
     * @param                     $data
     * @param TransformerAbstract $transformer
     *
     * @return Fractal
     */
    public function handle($data, TransformerAbstract $transformer)
    {
        $fractal = fractal()->transformWith($transformer)->serializeWith(new DataArraySerializer());
        if (static::isPaginatedResource($data)) {
            $fractal->paginateWith(new IlluminatePaginatorAdapter($data));
            $data = $data->getCollection();
        }

        return ($data instanceof Collection) ? $fractal->collection($data) : $fractal->item($data);
    }

    /**
     * Informa se o recurso sendo transformado utiliza o mecanismo de paginação.
     *
     * @param $data
     *
     * @return bool
     */
    protected static function isPaginatedResource($data): bool
    {
        return ($data instanceof LengthAwarePaginator);
    }
}
