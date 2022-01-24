<?php

namespace Modules\Bucket\Services;

use Modules\Bucket\Entities\Bucket;
use Modules\Bucket\Exceptions\BucketCapacityExceededException;
use Modules\Bucket\Exceptions\BucketContainFruitException;
use Modules\Bucket\Http\Requests\BucketRequest;
use Modules\Bucket\Services\interfaces\BucketInterface;
use Modules\Bucket\Services\interfaces\StorageInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BucketService
 */
class BucketService implements BucketInterface, StorageInterface
{

    /**
     * @param Bucket $model
     */
    public function __construct(
        protected Bucket $model
    )
    {
    }

    /**
     * @param BucketRequest $request
     * @return Bucket
     */
    public function store(BucketRequest $request): Bucket
    {
        return $this->model->create($request->all());
    }

    /**
     * @param int $bucketId
     * @return void
     * @throws BucketContainFruitException|NotFoundHttpException
     */
    public function delete(int $bucketId): void
    {
        $bucket = $this->model->find($bucketId);

        if(!$bucket) throw new NotFoundHttpException();
        if($bucket->fruits()->count() > 0) throw new BucketContainFruitException();

        $bucket->delete();
    }


    /**
     * @param Bucket $bucket
     * @return void
     * @throws BucketCapacityExceededException
     */
    private function validCapacity(Bucket $bucket): void
    {
        $totalFruits = $bucket->fruits()->count() + 1;
        if ($totalFruits > $bucket->capacity) throw new BucketCapacityExceededException();
    }

    /**
     * @param int $bucketId
     * @param int $fruitId
     * @return void
     * @throws BucketCapacityExceededException
     */
    public function addFruit(int $bucketId, int $fruitId): void
    {
        $bucket = $this->model->find($bucketId);
        $this->validCapacity($bucket);

        $bucket->fruits()->attach($fruitId);
    }

    /**
     * @param int $bucketId
     * @param int $fruitId
     * @return void
     */
    public function removeFruit(int $bucketId, int $fruitId): void
    {
        $bucket = $this->model->find($bucketId);
        $bucket->fruits()->detach($fruitId);
    }
}
