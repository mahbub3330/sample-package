<?php

namespace Gglink\Sample\Http\Controllers;

use App\Http\Controllers\Controller;
use Gglink\Sample\Requests\AuthenticateUserRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use GuzzleHttp\Exception\GuzzleException;

class AuthenticateController extends Controller
{
    /**
     * Redirect to login form
     * @return Application|Factory|View
     */
    public function loginForm()
    {
        return view('sample::auth.login');
    }

    /**
     * Verify Login
     * @param AuthenticateUserRequest $request
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function login(AuthenticateUserRequest $request)
    {
        $url = config('sample.api_base_url') . 'user/login';
        $data = $this->extracted($request, $url);
        if ($data->status == 200){
            \Session::put('token', $data->Token);
            return view('sample::dashboard');
        }
        return view('sample::login', ['InvalidCredential' => 'The username or password is invalid']);

    }

    /**
     * @return Application|Factory|View
     */
    public function logout()
    {
        return view('sample::auth.login');
    }

    public function requestToken(AuthenticateUserRequest $request)
    {
        $url = config('sample.api_base_url') . 'user/request_token';
        $data =  $this->extracted($request, $url);
        if ($data->status == 200){
            \Session::put('token', $data->Token);
        }
        return view('sample::auth.login', ['InvalidCredential' => 'The username or password is invalid']);
    }

    /**
     * @param AuthenticateUserRequest $request
     * @param string $url
     * @return mixed
     * @throws GuzzleException
     */
    public function extracted(AuthenticateUserRequest $request, string $url): mixed
    {
        $client = new \GuzzleHttp\Client();

        $header['X-API-KEY'] = config('gglink.api_key');
        $formData['Username'] = $request->get('username');
        $formData['Password'] = $request->get('password');

        $response = $client->post($url, [
            'headers' => $header,
            'form_params' => $formData,
            'http_errors' => false
        ]);

        return json_decode($response->getBody(), true);
    }
}
