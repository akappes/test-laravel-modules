<?php

namespace Modules\Fruit\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Fruit\Entities\Fruit;
use Modules\Fruit\Http\Requests\FruitRequest;
use Modules\Fruit\Transformers\FruitTransformer;
use Modules\Transformer\Traits\ApiResponse;

/**
 * Class FruitController
 */
class FruitController
{
    use ApiResponse;

    /**
     * @param Fruit $model
     */
    public function __construct(
        protected Fruit $model
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->respond(data: $this->transform($this->model->paginate(10), app(FruitTransformer::class)));
    }

    /**
     * @param FruitRequest $fruitRequest
     * @return JsonResponse
     */
    public function store(FruitRequest $fruitRequest): JsonResponse
    {
        $fruit = $this->model->create($fruitRequest->all());
        return $this->respondCreated(data: $this->transform($fruit, app(FruitTransformer::class)));
    }

    /**
     * @param int $id
     * @param FruitRequest $fruitRequest
     * @return JsonResponse
     */
    public function update(int $id, FruitRequest $fruitRequest): JsonResponse
    {
        $fruit = $this->model->find($id);

        if(!$fruit) return $this->failNotFound();

        $fruit->fill($fruitRequest->all())->save();

        return $this->respondUpdated(data: $this->transform($fruit, app(FruitTransformer::class)));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $fruit = $this->model->find($id);

        if(!$fruit) return $this->failNotFound();

        $fruit->delete();

        return $this->respondDeleted();
    }
}
