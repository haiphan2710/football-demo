<?php

namespace HaiPG\LaravelCore\Traits;

use Illuminate\Http\JsonResponse;

trait CreateToken
{
    /**
     * Create token
     *
     * @return JsonResponse
     */
    protected function tokenResponse()
    {
        $this->user->tokens()->delete();

        $site        = $this->isUser() ? ' User' : '';
        $token       = $this->user->createToken( config('app.name') . $site . ' Personal Access Portal');

        if ($this->isUser()) {
            $token->token->update(['expires_at' => now()->addHours(8)]);
        }

        return response()->json([
            'token_type'          => 'Bearer',
            'access_token'        => $token->accessToken,
            'expires_in'          => $token->token->expires_at,
            'user'                => $this->user
        ]);
    }

    protected function isUser()
    {
        return (is_a($this->user, 'App\Models\User'));
    }
}
