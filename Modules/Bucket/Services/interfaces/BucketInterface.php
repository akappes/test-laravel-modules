<?php

namespace Modules\Bucket\Services\interfaces;

use Modules\Bucket\Entities\Bucket;
use Modules\Bucket\Http\Requests\BucketRequest;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface BucketInterface
{
    public function list(): LengthAwarePaginator|null;

    public function store(BucketRequest $request): Bucket;

    public function delete(int $bucketId): void;
}
