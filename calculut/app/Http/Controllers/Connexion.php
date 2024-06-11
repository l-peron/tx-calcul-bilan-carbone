<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class Connexion extends Controller
{
    /**
     * Handle the authentication process.
     *
     * @param  Request $request
     * @return void
     */
    public function auth(Request $request): mixed
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider(
            [
                "clientId" => config('app.OAUTH_clientId'),
                "clientSecret" => config('app.OAUTH_clientSecret'),
                "redirectUri" => config('app.OAUTH_redirectUri'),
                "urlAuthorize" => "https://auth.assos.utc.fr/oauth/authorize",
                "urlAccessToken" => "https://auth.assos.utc.fr/oauth/token",
                "urlResourceOwnerDetails" => "https://auth.assos.utc.fr/api/user",
                "baseUrl" => "https://auth.assos.utc.fr/api/user",
                "scopes" => "users-infos read-assos read-memberships",
            ]
        );

        // If the authorization code is not present, authenticate the user
        if (empty($request->input('code'))) {
            // Get the authorization URL
            $authUrl = $provider->getAuthorizationUrl();

            // Store the OAuth2 state in the session
            session(['oauth2state' => $provider->getState()]);
            Log::info('Storing provider state ' . session('oauth2state'));

            return redirect($authUrl);
        } else {
            try {
                // Exchange the authorization code for an access token
                $accessToken = $provider->getAccessToken(
                    'authorization_code',
                    [
                    'code' => $request->input('code'),
                    ]
                );

                // Make a request to the authentication server to get user associations
                $response = Http::withToken($accessToken)->get('https://auth.assos.utc.fr/api/user/associations/current');

                if ($response->failed()) {
                    return response()->json(['message' => 'Error while getting user infos','JWT_ERROR' => true], 401);
                }
                $userAssos = $response->json();

                $userDetails = $provider->getResourceOwner($accessToken);
                $userFullName = $userDetails->toArray()['firstName'] . " " . $userDetails->toArray()['lastName'];


                if(in_array($userDetails->toArray()['email'], config()->get('app')['default_admins'])) {
                    array_push($userAssos, [ "shortname" => "BDE"]);
                }

                $request->session()->put('assos', $userAssos);
                $request->session()->put('fullName', $userFullName);

                // Create a cookie with the access token and set its expiration time to 1440 minutes (24 hours)
                $cookie = cookie(config('app.token_name'), $accessToken, 1440);

                return redirect('/assos/' . $userAssos[0]['shortname'])->withCookie($cookie);

            } catch (IdentityProviderException $e) {
                dd($e->getMessage());
            }
        }
    }

    /**
     * Logs out the user from Calcul'UT.
     *
     * @param  Request $request
     * @return mixed
     */
    public function logout(Request $request): mixed
    {
        $cookie = cookie(config('app.token_name'), null, -1);
        return redirect('https://auth.assos.utc.fr/logout')->withCookie($cookie);
    }
}
