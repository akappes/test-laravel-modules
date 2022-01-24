<?php

namespace Modules\Bucket\Services\interfaces;

interface StorageInterface
{
    public function addFruit(int $bucketId, int $fruitId): void;

    public function removeFruit(int $bucketId, int $fruitId): void;
}
