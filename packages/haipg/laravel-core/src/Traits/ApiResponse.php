<?php

namespace HaiPG\LaravelCore\Traits;

trait ApiResponse
{
    /**
     * return success response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSuccessResponse($message = null, $data = null, $code = null)
    {
        $response = [
            'success' => true,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        if (!is_null($data)) {
            $response['data'] = $data;
        }
        
        if ($code) {
            return response()->json($response, $code);
        }

        return response()->json($response);
    }
}
