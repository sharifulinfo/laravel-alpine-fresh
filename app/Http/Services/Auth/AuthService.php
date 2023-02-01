<?php

namespace App\Http\Services\Auth;

use App\Http\Services\BaseService;
use App\Http\Services\Users\WorkspaceService;
use App\Traits\helperTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class AuthService extends BaseService {
    use helperTrait;

    /**
     * @param $request
     *
     * @return JsonResponse
     */
    public function login($request): JsonResponse {
//        $this->reCaptchaValidate($request);
        $credentials = [
            'email'    => strtolower($request->email),
            'password' => $request->password,
        ];
//        try {
            if (Auth::attempt($credentials)) {
                $this->setRememberMe($request);
                $user_data = auth()->user();
                DB::table(TBL_USER)->where('id', $user_data->id)->update(['last_login_at' => date('Y-m-d H:i:s')]);
                $response_data = [
                    'id'        => $user_data->id,
                    'name'      => $user_data->name,
                    'email'     => $user_data->email,
                    'user_type' => $user_data->user_type,
                ];
                return $this->sResponse($response_data);
            } else {
                return $this->eResponse([], 'Invalid email or password');
            }
//        } catch (\Exception $e) {
//            return $this->eResponse($e);
//        }
    }

    public function registration($request): JsonResponse {
//        $this->reCaptchaValidate($request);
        $user = DB::table(TBL_USER)->where('email', $request->email)->count();
        if ($user > 0) {
            return $this->eResponse([], 'Sorry this email is already taken');
        }
        $userData = [
            'name'       => $request->name,
            'email'      => strtolower($request->email),
            'user_type'  => 'user',#admin
            'password'   => Hash::make($request->password),
        ];
        DB::table(TBL_USER)->insert($userData);
//        DB::table(TBL_USER)->insertGetId($userData);
        $credentials = [
            'email'    => strtolower($request->email),
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            return $this->sResponse($credentials);
        } else {
            return $this->eResponse([], 'Invalid email or password');
        }
    }

    /**
     * @param $request
     * @param $user_social_data
     * @param $driver
     *
     * @return JsonResponse
     */
    public
    function loginWithSocial($request, $user_social_data, $driver): JsonResponse {
        $user_exist = $this->mdb->search([
            'index' => TBL_USER,
            'size'  => 1,
            'body'  => [
                'query' => [
                    'match' => [
                        'email.keyword' => strtolower($user_social_data->email)
                    ]
                ]
            ]
        ])['hits']['hits'];
//        $userData = [];
        $userId = '';
        if (count($user_exist) > 0) {
            $userId = $user_exist[0]['_id'];
            $user_exist[0]['_source']['_id'] = $user_exist[0]['_id'];
            $userData = $user_exist[0]['_source'];

            try {
                $this->mdb->search([
                    'index' => TBL_WORKSPACE,
                    'id'    => $userData['active_ workspace']
                ]);
            } catch (\Throwable $th) {
                $ws = new WorkspaceService();
                $ws->activeDefaultWorkspace($userId);
            }

            Session::put('LoggedInUserId', $user_exist[0]['_id']);
            Auth::loginUsingId($userData);
            return $this->sResponse([]);
        } else {
            $id = randomString(32);
            $prepare_reg_data = $this->prepareUserData($request, 'social', $user_social_data, $driver);
            $ws = new WorkspaceService();
            $workspace = $ws->createDefaultWorkspace($id);
            sleep(1.5);
            $ws->addMemberToWorkspace($workspace['id'], $id);
            $prepare_reg_data['active_workspace'] = $workspace['id'];
            if ($prepare_reg_data['email'] != "") {
                $regUser = $this->mdb->index([
                    'index' => TBL_USER,
                    'id'    => $id,
                    'body'  => $prepare_reg_data
                ]);
                if ($regUser) {
                    $this->mdb->index([
                        'index' => TBL_PROSPECT_LIST,
                        'id'    => randomString(32),
                        'body'  => [
                            'workspace_id' => $workspace['id'],
                            'user_id'      => $id,
                            'name'         => 'Graveyard List',
                            'quantity'     => 0,
                            'is_graveyard' => 1,
                            'created_at'   => time(),
                            'updated_at'   => time(),
                        ]
                    ]);
                    $prepare_reg_data['_id'] = $id;
                    Session::put('LoggedInUserId', $id);
                    Auth::loginUsingId($prepare_reg_data);
                } else {
                    return $this->eResponse([], 'Registration failed');
                }
            } else {
                return $this->eResponse([], 'Email not Found');
            }
            return $this->sResponse([]);
        }
    }

    public
    function __resendVerifyEmail() {
        try {
            $str = randomString(32);
            $this->mdb->update([
                'index' => TBL_USER,
                'id'    => auth()->user()->_id,
                'body'  => [
                    'doc' => [
                        'email_verify_token' => $str
                    ]
                ]
            ]);

            $data = [
                'id'                 => auth()->user()->_id,
                'email_verify_token' => $str,
                'name'               => auth()->user()->name,
                'email'              => auth()->user()->email,
            ];

            if (config('app.debug') == FALSE) {
                $d = Mail::send('mails.verify-email', $data, function ($message) use ($data) {
                    $message->from('team@outreachbin.com', 'OutreachBin');
                    $message->to($data['email'])->subject('Verify your account - OutreachBin');
                });
            }
            return $this->sResponse();
        } catch (\Exception $exception) {
            return $this->eResponse([], $exception->getMessage());
        }
    }

    public
    function verifyEmail($id, $token) {
        try {
            $user = $this->mdb->get([
                'index' => TBL_USER,
                'id'    => $id,
            ]);

            if ($user['_source']['email_verify_token'] == $token) {
                $this->mdb->update([
                    'index' => TBL_USER,
                    'id'    => $id,
                    'body'  => [
                        'doc' => [
                            'email_verified_at'  => time(),
                            'email_verify_token' => '',
                        ]
                    ]
                ]);
                $data = [
                    'name'  => $user['_source']['name'],
                    'email' => $user['_source']['email'],
                ];
                try {
                    if (config('app.debug') == FALSE) {
                        Mail::send('mails.greetings', $data, function ($message) use ($data) {
                            $message->from('team@outreachbin.com', 'OutreachBin');
                            $message->to($data['email'])->subject('Welcome to OutReachbin');
                        });
                    }
                } catch (\Throwable $th) {
                }
                return redirect(LIVE_URL);
            }
            return redirect(LIVE_URL);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public
    function rememberMeCheck(): void {
        if (isset($_COOKIE[REMEMBERME]) && !empty($_COOKIE[REMEMBERME])) {
            $token = $this->mdb->search([
                'index' => TBL_USER,
                'size'  => 1,
                'body'  => [
                    'query' => [
                        'match' => [
                            'remember_token.keyword' => $_COOKIE[REMEMBERME]
                        ]
                    ]
                ]
            ])['hits']['hits'];
            if (count($token) > 0) {
                Auth::loginUsingId(['_id' => $token[0]['_id']]);
                sleep(1);
            }
        }
    }

    /**
     * @param $request
     *
     * @return void
     */
    public
    function setRememberMe($request): void {
        if (isset($request->remember) && $request->remember == 'true') {
            $token = randomString(32);
            setcookie(REMEMBERME, $token, time() + (86400 * 7), "/"); // 86400 = 1 day
            $this->mdb->update([
                'index' => TBL_USER,
                'id'    => auth()->user()->_id,
                'body'  => [
                    'doc' => [
                        'remember_token' => $token
                    ]
                ]
            ]);
        }
    }

    /**
     * @param $request
     *
     * @return JsonResponse|void
     */
    public
    function reCaptchaValidate($request) {
        $checkReCaptcha = $this->checkReCaptacha($request->all());
        if (config('app.debug') == 'true') {
            $checkReCaptcha['status'] = 'success';
        }
        if (isset($checkReCaptcha['status']) && $checkReCaptcha['status'] != 'success') {
            return $this->eResponse([], $checkReCaptcha['msg']);
        }
    }
}
