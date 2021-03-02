<?php


namespace Anam\SanctumSupport\Traits;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait ResetsPasswords
{
    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        if ($this->attemptResetPassword($request)) {
            return $this->sendPasswordResetResponse($request);
        }

        return response()->json(['success' => false, 'message' => 'Password reset token is invalid.']);
    }

    protected function attemptResetPassword(Request $request)
    {
        $check = DB::table('password_resets')->where('token', $request->token)->first();

        if (!is_null($check)) {
            $user = User::where('email', $check->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_resets')->where('token', $request->token)->delete();
            return true;
        }

        return false;
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    protected function sendPasswordResetResponse(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Congrats! Your password reset successfully']);
    }
}
