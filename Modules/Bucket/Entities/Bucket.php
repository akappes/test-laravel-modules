<?php

namespace Modules\Bucket\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bucket
 */
class Bucket extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'buckets';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'capacity'
    ];

    protected $casts = [
      'capacity' => 'integer'
    ];
}
