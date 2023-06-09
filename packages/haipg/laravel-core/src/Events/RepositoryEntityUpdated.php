<?php

namespace HaiPG\LaravelCore\Events;

use Illuminate\Database\Eloquent\Model;

class RepositoryEntityUpdated
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}