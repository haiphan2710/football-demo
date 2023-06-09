<?php

namespace HaiPG\LaravelCore\Exceptions;

use HaiPG\LaravelCore\Core\BaseException;

class RepositoryException extends BaseException
{
    public static function invalidMethod()
    {
        return self::code('repository.invalid_method');
    }

    public static function invalidModel()
    {
        return self::code('repository.invalid_model');
    }
}
