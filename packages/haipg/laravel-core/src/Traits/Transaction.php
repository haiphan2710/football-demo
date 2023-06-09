<?php

namespace HaiPG\LaravelCore\Traits;

use DB;

trait Transaction
{
    protected function beginTransaction()
    {
        DB::beginTransaction();
    }

    protected function commit()
    {
        DB::commit();
    }

    protected function rollback()
    {
        DB::rollback();
    }
}
