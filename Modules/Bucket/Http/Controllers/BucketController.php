<?php

namespace Modules\Bucket\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Modules\Bucket\Entities\Bucket;
use Modules\Bucket\Exceptions\BucketContainFruitException;
use Modules\Bucket\Http\Requests\BucketRequest;
use Modules\Bucket\Services\interfaces\BucketInterface;
use Modules\Bucket\Transformers\BucketTransformer;
use Modules\Transformer\Traits\ApiResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BucketController
 */
class BucketController
{
    use ApiResponse;

    /**
     * @param BucketInterface $bucketInterface
     */
    public function __construct(
        protected BucketInterface $bucketInterface
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $buckets = $this->bucketInterface->list();
        return $this->respond(data: $this->transform($buckets, app(BucketTransformer::class)));
    }

    /**
     * @param BucketRequest $bucketRequest
     * @return JsonResponse
     */
    public function store(BucketRequest $bucketRequest): JsonResponse
    {
        $bucket = $this->bucketInterface->store(
            request: $bucketRequest
        );
        return $this->respondCreated(data: $this->transform($bucket, app(BucketTransformer::class)));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $this->bucketInterface->delete(bucketId: $id);
        } catch (NotFoundHttpException $error) {
            return $this->failNotFound();
        } catch (BucketContainFruitException $error) {
            return $this->failValidationError($error->getMessage());
        } catch (\Exception $error) {
            Log::error($error->getMessage(), $error->getTrace());
            return $this->failServerError();
        }

        return $this->respondDeleted();
    }
}
