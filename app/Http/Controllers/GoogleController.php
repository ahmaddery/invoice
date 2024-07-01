<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        if (auth()->check()) {
            return redirect()->intended('dashboard');
        }

        return Socialite::driver('google')->stateless()->redirect();
    }
    
    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $findUser = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($findUser) {
                $this->updateGoogleTokens($findUser, $googleUser);
            } else {
                $findUser = $this->createNewUser($googleUser);
            }

            Auth::login($findUser);

            // Determine redirect based on user type
            if ($findUser->usertype === 'admin') {
                return "<script>window.opener.location.href='/admin/dashboard'; window.close();</script>";
            }

            return "<script>window.opener.location.href='/dashboard'; window.close();</script>";

        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Failed to login using Google.');
        }
    }

    /**
     * Update user's Google tokens if necessary.
     *
     * @param User $user
     * @param \Laravel\Socialite\Contracts\User $googleUser
     * @return void
     */
    private function updateGoogleTokens(User $user, $googleUser)
    {
        if ($googleUser->token !== $user->google_token || $googleUser->refreshToken !== $user->google_refresh_token) {
            $user->update([
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        }
    }

    /**
     * Create a new user using Google authentication.
     *
     * @param \Laravel\Socialite\Contracts\User $googleUser
     * @return User
     */
    private function createNewUser($googleUser)
    {
        $password = Str::random(20);

        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'password' => Hash::make($password),
        ]);

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeMail($user, $password));

        return $user;
    }

    /**
     * Check if the Google token has expired.
     *
     * @param string $token
     * @return bool
     */
    private function tokenExpired($token)
    {
        $tokenParts = explode('.', $token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);

        $expiry = Carbon::createFromTimestamp($jwtPayload->exp);
        return Carbon::now()->gte($expiry);
    }

    /**
     * Refresh the Google token using the refresh token.
     *
     * @param User $user
     * @return void
     */
    private function refreshGoogleToken(User $user)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'refresh_token' => $user->google_refresh_token,
                    'grant_type' => 'refresh_token',
                ],
            ]);

            $responseData = json_decode((string) $response->getBody(), true);

            if (isset($responseData['access_token'])) {
                $user->update([
                    'google_token' => $responseData['access_token'],
                ]);
            } else {
                Log::error('Failed to refresh Google token: ' . $response->getBody());
            }
        } catch (\Exception $e) {
            Log::error('Failed to refresh Google token: ' . $e->getMessage());
        }
    }
}
