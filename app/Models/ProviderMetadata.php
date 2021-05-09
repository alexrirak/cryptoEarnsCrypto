<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProviderMetadata extends Model
{
    /**
     * Indicates whether the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Stops Laravel from managing the dates -> the db is able to do it just fine
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * User constructor. Sets id to a uuid on creation
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->id = (string) Str::uuid();
    }
}
