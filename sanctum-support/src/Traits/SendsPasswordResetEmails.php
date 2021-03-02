<?php


namespace Anam\SanctumSupport\Traits;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

trait SendsPasswordResetEmails
{
    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Your email address was not found.']);
        }

        $token = $this->createPasswordResetToken($request);

        $this->sendForgotPasswordEmail($user, $token);

        return $this->sendForgotPasswordResponse();
    }

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    protected function createPasswordResetToken(Request $request)
    {
        $token = Str::random(8);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        return $token;
    }

    protected function sendForgotPasswordEmail(User $user, $token)
    {
        $user->token = $token;

        Mail::send('sanctum::emails.forgot', ['data' => $user], function ($message) use ($user) {
            $message->subject('Password reset code.');
            $message->to($user->email, $user->name);
        });
    }

    protected function sendForgotPasswordResponse()
    {
        return response()->json(['success' => true, 'message' => 'A reset email has been sent! Please check your email.']);
    }
}
