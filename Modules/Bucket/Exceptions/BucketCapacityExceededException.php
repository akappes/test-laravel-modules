<?php

namespace Modules\Bucket\Exceptions;

class BucketCapacityExceededException extends \Exception
{
    protected $message = "Excedido a capacidade máxima";
}
