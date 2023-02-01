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


class AuthService  extends BaseService {
    use helperTrait;

    /**
     * @param $request
     *
     * @return JsonResponse
     */
    public function login($request): JsonResponse {


        $this->reCaptchaValidate($request);



        $credentials = [
            'email'    => strtolower($request->email),
            'password' => $request->password,
        ];
        pp($credentials);

        try {
            if (Auth::attempt($credentials)) {
                $this->setRememberMe($request);
                $user_data = auth()->user();



                $this->mdb->update([
                    'index' => TBL_USER,
                    'id'    => $user_data->_id,
                    'body'  => [
                        'doc' => [
                            'last_login_at' => time()
                        ]
                    ]
                ]);
                $response_data = [
                    'id'        => $user_data->_id,
                    'name'      => $user_data->name,
                    'email'     => $user_data->email,
                    'user_type' => $user_data->user_type,
                ];
                return $this->sResponse($response_data);
            } else {
                return $this->eResponse([], 'Invalid email or password');
            }
        } catch (\Exception $e) {
            return $this->eResponse($e);
        }
    }

    public function registration($request): JsonResponse {
        $this->reCaptchaValidate($request);
        $alreadyExists = $this->mdb->count([
            'index' => TBL_USER,
            'body'  => [
                'query' => [
                    'match' => [
                        'email.keyword' => strtolower($request->email)
                    ]
                ]
            ]
        ])['count'];
        if ($alreadyExists > 0) {
            return $this->eResponse([], 'email_exists');
        } else {
            $prepare_reg_data = $this->prepareUserData($request, 'registration');
            $ws = new WorkspaceService();
            $id = randomString(32);
            $workspace = $ws->createDefaultWorkspace($id);
            sleep(1.5);
            $ws->addMemberToWorkspace($workspace['id'], $id);
            $prepare_reg_data['active_workspace'] = $workspace['id'];
            $regUser = $this->mdb->index([
                'index' => TBL_USER,
                'id'    => $id,
                'body'  => $prepare_reg_data
            ]);
            if (!$regUser) {
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
                return $this->eResponse([], 'Register not success');
            } else {
                sleep(2);
                /*if (config('app.debug') == FALSE) {
                    Mail::send('mails.verify-email', $prepare_reg_data, function ($message) use ($prepare_reg_data) {
                        $message->from('team@outreachbin.com', 'OutreachBin');
                        $message->to($prepare_reg_data['email'])->subject('Verify your account - OutreachBin');
                    });
                }

                try {
                    if (config('app.debug') == FALSE) {
                        Mail::send('mails.greetings', $prepare_reg_data, function ($message) use ($prepare_reg_data) {
                            $message->from('team@outreachbin.com', 'OutreachBin');
                            $message->to($prepare_reg_data['email'])->subject('Welcome to OutReachbin');
                        });
                    }
                } catch (\Throwable $th) {
                }*/

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
        }
    }

    /**
     * @param $request
     * @param $user_social_data
     * @param $driver
     *
     * @return JsonResponse
     */
    public function loginWithSocial($request, $user_social_data, $driver): JsonResponse {
        $user_exist = $this->mdb->search([
            'index' => TBL_USER,
            'size' => 1,
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
            }catch(\Throwable $th){
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

    /**
     * @param $request
     * @param string $mode
     * @param array $user_social_data
     * @param string $driver
     *
     * @return array
     */
    public function prepareUserData($request, string $mode = 'registration', $user_social_data = [], string $driver = ''): array {
        if (!isset($request->timezone)) {
            $timezone = 'UTC';
            $ipInfo = file_get_contents('http://ip-api.com/json/' . $request->ip);
            if (isset($ipInfo)) {
                $ipInfo = json_decode($ipInfo);
                if (isset($ipInfo->timezone)) {
                    $timezone = $ipInfo->timezone;
                }
            }
        } else {
            $timezone = $request->timezone;
        }
        $email = isset($user_social_data->email) ? $user_social_data->email : $request->email;

        $data = [
            "first_name"              => $request->first_name,
            "last_name"               => $request->last_name,
            "email"                   => strtolower($email),
            "email_verified_at"       => NULL,
            "email_verify_token"      => randomString(32),
            "remember_token"          => "",
            "status"                  => "active",
            "created_at"              => time(),
            "updated_at"              => time(),
            "trial_ends_at"           => Carbon::now()->addDays(14)->timestamp, //time()
            "trial_ended"             => 0,
            "active_workspace"        => NULL,
            "website"                 => NULL,
            "utm_source"              => isset($_COOKIE['utm_source']) ? $_COOKIE['utm_source'] : "",
            "utm_medium"              => isset($_COOKIE['utm_medium']) ? $_COOKIE['utm_medium'] : "",
            "utm_campaign"            => isset($_COOKIE['utm_campaign']) ? $_COOKIE['utm_campaign'] : "",
            "landing_page_url"        => isset($_COOKIE['landing_page_url_update']) ? $_COOKIE['landing_page_url_update'] : "",
            "user_type"               => USER_TYPE_USER,
            /*"permissions"             => $permissions,*/
            "ip"                      => $request->ip(),
            "profile_pic"             => '/backend/images/avatar.png',
            "timezone"                => $timezone,
            "last_login_at"           => time(),
            #onboarding details
            "registration_step"       => 2,
            "company"                 => '',
            "people_use_qty"          => '',
            "hear_about_us"           => '',
            "phone"                   => '',
            "business_model"          => 'business', # business,agency,other
            "business_area"           => [],
            #stripe Info
            "plan_type"               => 'free',
            "customer_id"                  => NULL,
            "price_id"                => '',
            "leads_limit"             => 15,
            "leads_limit_used"        => 0,
            "verification_limit"      => 15,
            "verification_limit_used" => 0,

        ];
        if ($mode === 'registration') {
            $data['name'] = $request->first_name . ' ' . $request->last_name;
            $data['phone'] = $request->phone;
//            $data['countryCode'] = $request->countryCode;
//            $data['phoneCode'] = $request->phoneCode;
            $data['password'] = Hash::make($request->password);
            $data['avatar'] = '';
            $data['register_from'] = 'salesMix';
        } else if ($mode === 'social') {
            $data['name'] = $user_social_data->name ?? '';
            $data['password'] = "";
            $data['avatar'] = $user_social_data->avatar ?? '';
            $data[$driver . '_id'] = $user_social_data->id ?? '';
            $data['register_from'] = $driver;
            $data['registration_step'] = 1;
            $data['email_verified_at'] = time();
            $data['email_verify_token'] = '';
        }
        if(empty($data['first_name'])){
            $data['first_name'] = explode(' ',  $data['name'])[0] ?? "";
        }
        if(empty($data['last_name'])){
            $data['last_name'] = explode(' ',  $data['name'])[1] ?? "";
        }

        return $data;
    }


    public function __resendVerifyEmail() {
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

    public function verifyEmail($id, $token) {
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

//    private function addUserInitialPlans($userId): string {
//        $data = [
//            #plan details
//            "user_id"                 => $userId,
//            "plan_name"               => '',
//            'subscription_type'       => 'free',
//            "email_sending_limit"     => 10,
//            "email_sending_used"      => 0,
//            "contacts_upload_limit"   => 100,
//            "contacts_upload_used"    => 0,
//            "verification_limit"      => 25,
//            "verification_limit_used" => 0,
//            "leads_limit"             => 25,
//            "leads_limit_used"        => 0,
//        ];
//        $id = randomString(32);
//        $this->mdb->index([
//            'index' => TBL_USER_CREDIT,
//            'id'    => $id,
//            'body'  => $data
//        ]);
//        return $id;
//    }

    /**
     * @return void
     */
    public function rememberMeCheck(): void {
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
    public function setRememberMe($request): void {
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
    public function reCaptchaValidate($request) {
        $checkReCaptcha = $this->checkReCaptacha($request->all());
        if (config('app.debug') == 'true') {
            $checkReCaptcha['status'] = 'success';
        }
        if (isset($checkReCaptcha['status']) && $checkReCaptcha['status'] != 'success') {
            return $this->eResponse([], $checkReCaptcha['msg']);
        }
    }
}
