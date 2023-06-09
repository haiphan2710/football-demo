<?php

namespace HaiPG\LaravelCore\Core;

use Closure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

abstract class BaseExport implements FromCollection
{
    /** @var BaseRepository $repository */
    protected $repository;

    /**
     * Return collection Data
     *
     * @return Collection
     */
    public function collection()
    {
        return $this->repository->all();
    }

    /**
     * Prepare some filters before exporting
     *
     * @param Closure $closure
     * @return self
     */
    public function filterData(Closure $closure)
    {
        $this->repository->scopeQuery($closure);

        return $this;
    }
}
