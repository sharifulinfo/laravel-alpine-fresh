<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;
use App\Http\Services\Auth\ResetPasswordService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    public function login(Request $request, AuthService $auth_service): View|Factory|JsonResponse|Redirector|RedirectResponse|Application {
        $data = [];
        if($request->ajax()){
            $validate = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required|min:8'
            ]);
            if ($validate->fails()) {
                return $this->eResponse([], $validate->errors()->first());
            } else {
                return $auth_service->login($request);
            }
        }else{
            $auth_service->rememberMeCheck();
            if (Auth::check()) {
                return redirect('dashboard');
            }
            $data['title'] = 'Login | SalesMix';
            return view('auth.sign-in', $data);
        }
    }
    public function registration(Request $request, AuthService $auth_service): View|Factory|JsonResponse|Application {
        $data = [];
        if($request->ajax()){
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'email'      => 'required|email',
                'password'   => 'required|min:8',
            ]);
            if ($validate->fails()) {
                return $this->eResponse([], $validate->errors()->first());
            }
            return $auth_service->registration($request);
        }else{
            $data['title'] = 'Signup | SalesMix';
            return view('auth.sign-up', $data);
        }
    }
    public function logout(): Redirector|Application|RedirectResponse {
        Auth::logout();
        if (isset($_COOKIE[REMEMBERME])) {
            unset($_COOKIE[REMEMBERME]);
            setcookie(REMEMBERME, '', time() - 3600, '/'); // empty value and old timestamp
        }
        return redirect('/');
    }

    /** Reset Password Code */
    public function resetPassword(Request $request, ResetPasswordService $rP): View|JsonResponse {
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'email'    => 'email|required|string',
                'code'     => 'required|string|min:5|max:5',
                'password' => 'required|min:8|same:password_confirmation',
            ]);
            if ($validator->fails()) {
                return $this->eResponse([], $validator->getMessageBag()->first());
            }
            return $rP->updatePassword($request);
        }else{
            $data['title'] = 'Reset Password | SalesMix';
            return view('auth.reset-password', $data);
        }
    }
    public function checkEmail(Request $request,ResetPasswordService $rP): JsonResponse {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required|string',
        ]);
        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        return $rP->sendResetCode($request);
    }
    public function checkCode(Request $request,ResetPasswordService $rP): JsonResponse {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required|string',
            'code' => 'required|min:5|max:5',
        ]);
        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        $code = strtoupper($request->code);
        return $rP->verifyCode($request->email, $code);
    }

}
