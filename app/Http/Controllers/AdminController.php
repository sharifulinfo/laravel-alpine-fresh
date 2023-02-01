<?php

namespace App\Http\Controllers;

use App\Http\Services\Admin\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {
    private $uService;
    public function __construct() {
        $this->uService = new UserService();
    }
    public function dashboard(): View {
        $data = [];
        $data['title'] = 'Dashboard - ' . SITE_TITLE;
        $data['description'] = SITE_TAG;
        return view('admin.dashboard', $data);
    }
}
