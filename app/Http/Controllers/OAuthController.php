<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OAuthController extends Controller
{
    public function redirect()
    {
        $queries = http_build_query([
            'client_id' => 3,
            'redirect_uri' => 'http://10.3.2.51:8002/oauth/callback',
            'response_type' => 'code',
        ]);

        return redirect('http://10.3.2.51:8003/oauth/authorize?' . $queries);
    }

    public function callback(Request $request)
    {
//        return $request->code;
        $response = Http::post('http://10.3.2.51:8003/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => 3,
            'client_secret' => 'w3GZe7MeEOZVmVxCINaVMP9yyzUbbB6Id8qdgIHW',
            'redirect_uri' => 'http://10.3.2.51:8002/oauth/callback',
            'code' => $request->code
        ]);
//return $response;
      return  $response = $response->json();
//return $response;

// $users=Http::get('http://api.test/user');
      return $token = $response['access_token']; // Replace 'YOUR_API_TOKEN' with your actual API token

        // Make a GET request to the API endpoint with the token included in the headers
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            // Add any other headers required by the API
        ])->get('http://10.3.2.51:8003/api/suite/user');

        if ($response->successful()) {
            $data = $response->json();
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
        return $users;
        $request->user()->token()->delete();

        $request->user()->token()->create([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect('/home');
    }

    public function refresh(Request $request)
    {
        $response = Http::post(config('services.oauth_server.uri') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->user()->token->refresh_token,
            'client_id' => config('services.oauth_server.client_id'),
            'client_secret' => config('services.oauth_server.client_secret'),
            'redirect_uri' => config('services.oauth_server.redirect'),
            'scope' => 'view-posts'
        ]);

        if ($response->status() !== 200) {
            $request->user()->token()->delete();

            return redirect('/home')
                ->withStatus('Authorization failed from OAuth server.');
        }

        $response = $response->json();
        $request->user()->token()->update([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect('/home');
    }
}
