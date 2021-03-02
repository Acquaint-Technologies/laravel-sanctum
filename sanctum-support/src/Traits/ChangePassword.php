<?php


namespace Anam\SanctumSupport\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait ChangePassword
{
    public function change(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        if ($this->attemptChangePasssword($request)) {
            return $this->sendPasswordChangeResponse();
        }

        return response()->json(['success' => false, 'message' => 'Old Password does not match.']);
    }

    /**
     * Get the password change validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'old_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    /**
     * Get the password change validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    protected function attemptChangePasssword(Request $request)
    {
        $check = Hash::check($request->old_password, request()->user()->password);
        if ($check) {
            $user = request()->user();
            $user->password = Hash::make($request->password);
            $user->save();
            return true;
        }
        return false;
    }

    protected function sendPasswordChangeResponse()
    {
        return response()->json(['success' => true, 'message' => 'Congrats! Your password changed successfully']);
    }
}
