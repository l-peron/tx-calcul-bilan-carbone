<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LogicException;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  Request                      $request
     * @param  Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the JWT token from the cookie
        $token = $request->cookie(config('app.token_name'));
        // If the token is null, redirect to authentication route with the current route stored in a cookie
        if ($token == null) {
            return redirect()->route('auth_route');
        }

        try {
            // Decode the JWT token using the public key
            $public_key_path = storage_path('app/keys/public.key');
            $public_key = openssl_get_publickey('file://' . $public_key_path);

            JWT::decode($token, new Key($public_key, 'RS256'));

            // Enrich the session
            $userAssos = Http::withToken($token)->get('https://auth.assos.utc.fr/api/user/associations/current')->json();
            $identity = Http::withToken($token)->get('https://auth.assos.utc.fr/api/user')->json();
            $userFullName = $identity['firstName'] . " " . $identity['lastName'];

            if(in_array($identity['email'], config()->get('app')['default_admins'])) {
                array_push($userAssos, [ "shortname" => "BDE"]);
            }

            $request->session()->put('assos', $userAssos);
            $request->session()->put('fullName', $userFullName);

        } catch (ExpiredException) {
            return response()->json(['message' => 'Json Web Token Expired', 'JWT_ERROR' => true], 401);
        } catch (SignatureInvalidException) {
            return response()->json(['message' => 'Invalid Signature In Sent Json Web Token', 'JWT_ERROR' => true], 401);
        } catch (LogicException) {
            return response()->json(['message' => 'Error having to do with environmental setup or malformed JWT Keys', 'JWT_ERROR' => true], 401);
        } catch (UnexpectedValueException) {
            return response()->json(['message' => 'Error having to do with JWT signature and claims', 'JWT_ERROR' => true], 401);
        }

        // Continue with the request
        return $next($request);
    }
}
