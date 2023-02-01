<?php

namespace App\Http\Controllers;

use App\Http\Services\Users\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    public function dashboard() {
        $data = [];
        $data['title'] = 'Dashboard - ' . SITE_TITLE;
//        if (auth()->user()->user_type === 'admin') {
//            return redirect()->route('adminDashboard');
//        }
        return view('users.dashboard.dashboard', $data);
    }
}
