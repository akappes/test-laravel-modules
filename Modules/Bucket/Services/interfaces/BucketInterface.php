<?php

namespace Modules\Bucket\Services\interfaces;

use Modules\Bucket\Entities\Bucket;
use Modules\Bucket\Http\Requests\BucketRequest;

interface BucketInterface
{
    public function store(BucketRequest $request): Bucket;

    public function delete(int $bucketId): void;
}
