<?php

namespace Modules\Bucket\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Bucket\Entities\Bucket;
use Modules\Bucket\Http\Requests\BucketRequest;
use Modules\Bucket\Transformers\BucketTransformer;
use Modules\Transformer\Traits\ApiResponse;

/**
 * Class BucketController
 */
class BucketController
{
    use ApiResponse;

    /**
     * @param Bucket $model
     */
    public function __construct(
        protected Bucket $model
    )
    {
    }

    /**
     * @param BucketRequest $bucketRequest
     * @return JsonResponse
     */
    public function store(BucketRequest $bucketRequest): JsonResponse
    {
        $fruit = $this->model->create($bucketRequest->all());
        return $this->respondCreated(data: $this->transform($fruit, app(BucketTransformer::class)));
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
