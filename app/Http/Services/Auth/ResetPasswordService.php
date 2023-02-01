<?php

namespace App\Http\Services\Auth;

use App\Http\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordService extends BaseService {
    public function sendResetCode($request): JsonResponse {
//        try {
            $user = $this->mdb->search([
                'index' => TBL_USER,
                'size'  => 1,
                'body'  => [
                    'query' => [
                        'match' => [
                            'email.keyword' => strtolower($request->email)
                        ]
                    ]
                ]
            ])['hits']['hits'];
            if (count($user) == 0) {
                return $this->eResponse([], 'Sorry! we are unable to find your <b> email </b> address.');
            }

            $code = strtoupper(randomString(5));

            $data = [
                'code'     => $code,
                'code_arr' => str_split($code),
                'email'    => $user[0]['_source']['email'],
                'name'     => $user[0]['_source']['name'],
                'subject'  => "Reset Password - SalesMix",
            ];

            $this->mdb->update([
                'index' => TBL_USER,
                'id'    => $user[0]['_id'],
                'body'  => [
                    'doc' => [
                        'reset_password_otp'        => $code,
                        'reset_password_otp_expire' => Carbon::now()->addHours(24)->timestamp
                    ]
                ]
            ]);

            if (!config('app.debug')) {
               Mail::send('mails.reset-password', $data, function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['subject']);
               });
            }

            return $this->sResponse([],"A <b>verification</b> code successfully sent to your email address");
//        } catch (\Throwable $th) {
//            return $this->eResponse($th->getMessage());
//        }
    }

    public function verifyCode($email, $code): JsonResponse {
        $user = $this->mdb->search([
            'index' => TBL_USER,
            'size'  => 1,
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'email.keyword' => $email
                                ]
                            ],
                            [
                                'match' => [
                                    'reset_password_otp.keyword' => $code
                                ]
                            ],
                            [
                                'range' => [
                                    'reset_password_otp_expire' => [
                                        'gte' => time()
                                    ]
                                ]
                            ],
                        ]
                    ]

                ]
            ]
        ])['hits']['hits'];
        if (count($user) == 0) {
            return $this->eResponse([], "Sorry! you are providing <b>invalid</b> code!");
        }
        return $this->sResponse(['email' => $email, 'code' => $code]);
    }

    public function updatePassword($request): JsonResponse {
        try {
            $user = $this->mdb->search([
                'index' => TBL_USER,
                'size'  => 1,
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'match' => [
                                        'email.keyword' => strtolower($request->email)
                                    ]
                                ],
                                [
                                    'match' => [
                                        'reset_password_otp.keyword' => strtoupper($request->code)
                                    ]
                                ],
                                [
                                    'range' => [
                                        'reset_password_otp_expire' => [
                                            'gte' => time()
                                        ]
                                    ]
                                ],
                            ]
                        ]

                    ]
                ]
            ])['hits']['hits'];
            if (count($user) == 0) {
                return $this->eResponse([], 'Invalid email or code! Please try again');
            }
            $this->mdb->update([
                'index' => TBL_USER,
                'id'    => $user[0]['_id'],
                'body'  => [
                    'doc' => [
                        'password'                  => Hash::make($request->password),
                        'reset_password_otp'        => '',
                        'reset_password_otp_expire' => 0
                    ]
                ]
            ]);
            return $this->sResponse([], 'Congress! your password has been successfully updated!');
        } catch (\Throwable $th) {
            return $this->eResponse($th->getMessage());
        }
    }
}
