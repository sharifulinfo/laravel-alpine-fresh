<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller {
    private $authService;

    /**
     * @param AuthService $service
     */
    public function __construct(AuthService $service) {
        $this->authService = $service;
    }

    /**
     * @param $driver
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($driver): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * @param Request $request
     * @param $driver
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function handleProviderCallback(Request $request, $driver): Redirector|RedirectResponse|Application {
        $socialite_user = Socialite::driver($driver)->stateless()->user();
        $login_response = $this->authService->loginWithSocial($request, $socialite_user, $driver);
        return redirect('dashboard');
    }
}
