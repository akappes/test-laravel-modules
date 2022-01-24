<?php

namespace Modules\Fruit\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Fruit\Scope\ExpirationScope;

class Fruit extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'price', 'expiration_at'
    ];

    /**
     * @var array<int, mixed>
     */
    protected $casts = [
        'expiration' => 'datetime:Y-m-d'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ExpirationScope);
    }
}
