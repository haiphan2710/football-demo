<?php

namespace HaiPG\LaravelCore\Contracts;

use HaiPG\LaravelCore\Contracts\RepositoryInterface;

interface CriteriaInterface
{
    /**
     * Apply the criteria
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \HaiPG\LaravelCore\Contracts\RepositoryInterface $repository
     * @return void
     */
    public function apply($model, RepositoryInterface $repository);
}
