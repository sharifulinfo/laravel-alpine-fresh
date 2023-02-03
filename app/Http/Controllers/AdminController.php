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
        return view('admin.users', $data);
    }
    public function users(): View {
        $data = [];
        $data['title'] = 'Users - ' . SITE_TITLE;
        $data['description'] = SITE_TAG;
        return view('admin.users', $data);
    }
    public function getUsers(Request $request): JsonResponse {
        return $this->uService->loadUsers($request);
    }

    public function getUserMetaAnalytics(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        return $this->uService->loadUserMetaAnalytics($request->ids);
    }
    public function spyUserLogin(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }

        try {
            Session::put('LoggedInUserId', auth()->user()->_id);
            Auth::loginUsingId(['_id' => $request->id]);
            return $this->sResponse([]);
        } catch (\Throwable $th) {
            return $this->eResponse([], 'User Not Found');
        }
    }
    public function blockUser(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|string',
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        try {
            return $this->uService->__updateUser(['status' => $request->type],$request->id);
        } catch (\Throwable $th) {
            return $this->eResponse([], $th->getMessage());
        }
    }
    public function spyUserLogout(Request $request): JsonResponse {
        if (session()->has('LoggedInUserId')) {
            try {
                Auth::loginUsingId(['_id' => session()->get('LoggedInUserId')]);
                Session::forget('LoggedInUserId');
                return $this->sResponse([]);
            } catch (\Throwable $th) {
                return $this->eResponse([], 'User Not Found');
            }
        }
        return $this->eResponse([], 'An unexpected server error has been occurred. Please try again.');
    }
    public function upgradeUser(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'id'            => 'required|string',
            'plan_type'     => 'required|string',
            'selected_plan' => 'required|string',
            'verification'  => 'required',
            'leads'         => 'required',
        ]);

        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        if ($request->plan_type === 'free') {
            return $this->uService->__downgradeUser($request);
        }
        return $this->uService->__upgradeUser($request);
    }
    public function updateUser(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'id'         => 'required|string',
            'first_name' => 'required|string',
            'last_name'  => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        $updateData = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'name'       => $request->first_name . ' ' . $request->last_name,
            'phone'      => $request->phone,
            'company'    => $request->company,
        ];
        if (!empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }
        return $this->uService->__updateUser($updateData,$request->id);
    }
    public function userUpgrade(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        return $this->uService->upgradeUser($request);
    }
    public function deleteUser(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'id'         => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->eResponse([], $validator->getMessageBag()->first());
        }
        return $this->uService->__deleteUser($request->id);
    }
    public function downloadUsers(): JsonResponse {
        return $this->uService->__downloadUsers();
    }

    #----------------------------------------------------------------------------- Workspaces
    public function workspace(): View {
        $data = [];
        $data['title'] = 'Workspace - ' . SITE_TITLE;
        $data['description'] = SITE_TAG;
        return view('admin.workspace', $data);
    }
    public function getWorkspaceList(Request $request,WorkspaceService $wService): JsonResponse {
        return $wService->loadWorkspace($request);
    }

    #------------------------------------------------------------------------------ Dashboard Analytics
    public function getStats(AnalyticsService $aService) : JsonResponse{
        return $aService->__getStats();
    }
    public function getSequenceChartData(AnalyticsService $aService) : JsonResponse{
        date_default_timezone_set('UTC');
        $limit = 30;
        $time = strtotime("-" . $limit . " day", strtotime(date('Y-m-d,00:00:00')));
        return $aService->__getSequenceChartData($time, $limit);
    }
    public function getWarmupChartData(AnalyticsService $aService) : JsonResponse{
        date_default_timezone_set('UTC');
        $limit = 15;
        $time = strtotime("-" . $limit . " day", strtotime(date('Y-m-d,00:00:00')));
        return $aService->__getWarmupChartData($time, $limit);
    }
}
