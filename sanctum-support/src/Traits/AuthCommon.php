<?php


namespace Anam\SanctumSupport\Traits;


use Illuminate\Http\Request;

trait AuthCommon
{
    /**
     * Override the method if needed.
     *
     * @return bool
     */
    protected function verify()
    {
        return false;
    }

    protected function createToken()
    {
        $this->token = $this->user->createToken('app-token')->plainTextToken;
    }

    protected function sendLoginResponse(Request $request)
    {
        return response()->json([
            'success' => true,
            'token' => $this->token,
            'user' => $this->user,
            'expires' => 365 * 24 * 60,
        ], 200);
    }

    protected function verifyUser()
    {
        if ($this->verify()) {
            if (!$this->user->email_verified_at) {
                return false;
            }
        }
        return true;
    }

    protected function sendVerifyResponse()
    {
        return response()->json(['message' => 'Verify', 'user_id' => $this->user->id], 200);
    }
}
