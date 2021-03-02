<?php

namespace Anam\SanctumSupport\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait AuthenticatesUsers
{
    use AuthCommon;

    protected $token;

    protected $user;

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'email';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            if (!$this->verifyUser()) {
                return $this->sendVerifyResponse();
            }
            $this->createToken();

            $this->authenticated($request, $this->user);
            return $this->sendLoginResponse($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $this->user = User::where($this->username(), $request->email)->first();

        if (!$this->user || !Hash::check($request->password, $this->user->password)) {
            return false;
        }

        return true;
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    public function logout(Request $request)
    {
        $this->user = auth()->user();

        if ($this->revokeToken()) {
            $this->loggedOut($request);
            return response()->json(['success' => true, 'message' => 'Logged out successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Something went wrong']);
    }

    protected function revokeToken()
    {
        return $this->user->tokens()->where('id', $this->user->currentAccessToken()->id)->delete();
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }
}
