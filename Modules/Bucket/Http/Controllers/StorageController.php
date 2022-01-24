<?php

namespace Modules\Bucket\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Modules\Bucket\Exceptions\BucketCapacityExceededException;
use Modules\Bucket\Http\Requests\StorageRequest;
use Modules\Bucket\Services\interfaces\StorageInterface;
use Modules\Transformer\Traits\ApiResponse;

/**
 * Class StorageController
 */
class StorageController
{
    use ApiResponse;

    /**
     * @param StorageInterface $fruitDepositInterface
     */
    public function __construct(
        protected StorageInterface $fruitDepositInterface
    )
    {
    }

    /**
     * @param StorageRequest $depositRequest
     * @return JsonResponse
     */
    public function add(StorageRequest $depositRequest): JsonResponse
    {
        try {
            $this->fruitDepositInterface->addFruit(
                bucketId: $depositRequest->get('bucket_id'),
                fruitId: $depositRequest->get('fruit_id'),
            );
        } catch (BucketCapacityExceededException $error) {
            return $this->failValidationError($error->getMessage());
        } catch (\Exception $error) {
            Log::error($error->getMessage(), $error->getTrace());
            return $this->failServerError();
        }
        return $this->respondNoContent();
    }

    /**
     * @param StorageRequest $request
     * @return JsonResponse
     */
    public function remove(StorageRequest $request): JsonResponse
    {
        $this->fruitDepositInterface->removeFruit(
            bucketId: $request->get('bucket_id'),
            fruitId: $request->get('fruit_id'),
        );
        return $this->respondNoContent();
    }
}
