<?php

namespace HaiPG\LaravelCore\Traits;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait JsonAPIResponses
{
    /**
     * Map out exceptions with an appropriate response.
     *
     * Note: Define $exceptionMapping before using this trait
     *
     * @var array
     */
//    protected $exceptionMapping = [];

    /**
     * Where we store our responses.
     *
     * @var string
     */
    protected $responsesNamespace = 'App\Http\Responses\Exceptions';

    /**
     * Render an exception to a JSON response.
     *
     * @param  Throwable  $exception
     * @return JsonResponse
     */
    protected function renderJsonExceptions(Throwable $exception)
    {
        $response = $this->responsesNamespace . '\\' . $this->getResponse($exception);

        return new $response($exception);
    }

    /**
     * Converts our mapping to a collection.
     *
     * @return Collection
     */
    protected function jsonExceptions()
    {
        return collect($this->exceptionMapping);
    }

    /**
     * Get the Response class name from our mapping.
     *
     * @param  Throwable  $exception
     * @return string|null
     */
    protected function getResponse(Throwable $exception)
    {
        return $this->jsonExceptions()->get(get_class($exception));
    }

    /**
     * The rules for converting the response from an exception
     * to a proper custom json-api response.
     *
     * @param  Throwable  $exception
     * @return bool
     */
    protected function shouldRenderExceptionToJson(Throwable $exception)
    {
        if (! request()->expectsJson()) {
            return false; // this return used for blade
        }

        return ! is_null($this->getResponse($exception));
    }
}
