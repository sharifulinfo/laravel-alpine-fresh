<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class DevController extends Controller {

    public function __construct() {
        $ip_address = '';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        $allowed_ip = [
            '103.112.149.98',
            '103.122.91.109',
            '103.79.182.157', // Nirjhar Home
            '180.211.233.14', // sharif Home
            '103.25.249.252', // official modem
            '127.0.0.1', // localhost
            '148.113.139.154'
        ];

    }

    function dev() {
        dd(auth()->user());
        exit();

        $bulk_insert = [];
        for ($i = 0; $i < 100; $i++) {
            $status = ['success', 'failed'];
            $bulk_insert['body'][] = [
                'index' => [
                    '_index' => 'analytics',
                    '_id'    => randomString(32),
                ]
            ];

            $bulk_insert['body'][] = [
                "sequence_id"         => "cw7m0zCkAn6GThFptISf8t2EEQESnohq",
                "email_provider_id"   => "vkg4o19w9sm6xvbajxjrsi8yqkvj27xt_steph@emaillatte.com",
                "followup_type"       => "email",
                "prospect_id"         => "vkG4o19W9Sm6XVBaJXJRSI8Yqkvj27xT_1pLm3g38bBhDJHzTwJE3bswCYa3ReiZV_lpearson3@homestead.com",
                "prospect_mapping_id" => "cw7m0zCkAn6GThFptISf8t2EEQESnohq_lpearson3@homestead.com",
                "prospect_email"      => "lpearson3@homestead.com",
                "message_id"          => "EHwZIdrh8wHqy9V7brTvE56AYagYVGEq",
                "sequence"            => 1,
                "mail_id"             => "185e8b5514822126",
                "timezone"            => "Europe/Isle_of_Man",
                "workspace_id"            => "vkG4o19W9Sm6XVBaJXJRSI8Yqkvj27xT",

                "sent"                => 1,
                "sent_at"             => strtotime("-" . rand(60,500) . " minutes", time()),
                "sent_at_date"        => date('Y-m-d'),

                "opened"              => 1,
                "opened_at"           => strtotime("-" . rand(60,500) . " minutes", time()),
                "opened_at_date"      => date('Y-m-d'),

                'clicked'             => rand(0,1),
                'clicked_at'          => strtotime("-" . rand(60,500) . " minutes", time()),
                'clicked_at_date'     => date('Y-m-d'),

                'unsubscribed'        => rand(0,1),
                'unsubscribed_at'     => strtotime("-" . rand(60,500) . " minutes", time()),
                'unsubscribed_reason' => "msg",

                'bounced'             => rand(0,1),
                'bounced_at'          => strtotime("-" . rand(60,500) . " minutes", time()),
                'bounced_at_date'     => date('Y-m-d'),

                "created_at"          => time(),
                "updated_at"          => time(),
            ];

//            QDB()->index([
//                'index' => 'sequence_logs',
//                'id'    => randomString(32),
//                'body'  => [
//
//                ]
//            ]);
        }
        MDB()->bulk($bulk_insert);
        exit();
        date_default_timezone_set('UTC');
        $users = MDB()->search([
            'index' => TBL_USER,
            'size'  => 100,
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'plan_interval.keyword' => 'year'
                                ]
                            ],
                            [
                                'match' => [
                                    'plan_next_recurring_at' => date('Y-m-d')
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ])['hits']['hits'];
        pp($users);

//        exit();
        $email = "9RARGf38iAiSFmXqvOdumZQvqsAW1Pig_shariful.info60@gmail.com";
        $ups = [
            "zCYFlqYzckkqeD5TgRPvdLsk0Cno1IZk_2023-01-10" => [
                "email_provider_id" => $email,
                "sent"              => 7,
                "moved_from_spam"   => 0,
                "replied"           => 0,
                "moved_from_other"  => 0,
                "updated_at"        => 1673332955,
                "created_at"        => 1673332955
            ],
            "9kIbM8mOEXfzapQZf0UWc2ix4eRIRKyE_2023-01-10" => [
                "email_provider_id" => $email,
                "sent"              => 3,
                "moved_from_spam"   => 0,
                "replied"           => 0,
                "moved_from_other"  => 0,
                "updated_at"        => 1673332955,
                "created_at"        => 1673332955
            ],
            "FzWif8Fe5wNu0IpkAXuKpCupokInBov0_2023-01-10" => [
                "email_provider_id" => $email,
                "sent"              => 5,
                "moved_from_spam"   => 0,
                "replied"           => 1,
                "moved_from_other"  => 0,
                "updated_at"        => 1673332955,
                "created_at"        => 1673332955
            ],
            "2p9Td6Zu57XiPv26t8pkuR8G1YBxWw4M_2023-01-10" => [
                "email_provider_id" => $email,
                "sent"              => 4,
                "moved_from_spam"   => 1,
                "replied"           => 0,
                "moved_from_other"  => 0,
                "updated_at"        => 1673332955,
                "created_at"        => 1673332955
            ],
            "PLUyi5dMRAaN1txynAaB2MPZtOiuu2CV_2023-01-10" => [
                "email_provider_id" => $email,
                "sent"              => 4,
                "moved_from_spam"   => 0,
                "replied"           => 0,
                "moved_from_other"  => 0,
                "updated_at"        => 1673332955,
                "created_at"        => 1673332955
            ],
            "VxemK7GQU1m5nxDxcwTvrzXoCgTYdR9g_2023-01-10" => [
                "email_provider_id" => $email,
                "sent"              => 4,
                "moved_from_spam"   => 0,
                "replied"           => 3,
                "moved_from_other"  => 0,
                "updated_at"        => 1673332955,
                "created_at"        => 1673332955
            ],
            "0CMgBPsxqBBNfj01cilWNNtnUapBnWPI_2023-01-10" => [
                "email_provider_id" => $email,
                "sent"              => 4,
                "moved_from_spam"   => 2,
                "replied"           => 4,
                "moved_from_other"  => 0,
                "updated_at"        => 1673332955,
                "created_at"        => 1673332955
            ],
        ];
        foreach ($ups as $k => $u) {
            MDB()->index([
                'index' => TBL_WARM_UP,
                'id'    => $k,
                'body'  => $u
            ]);
        }

        exit();
//        dd(auth()->user());
//        MDB()->updateByQuery([
//            'index' => TBL_WORKSPACE,
//            'body'  => [
//                'query'  => [
//                    'match' => [
//                        '_id' => 'kZI84w5kld0BjlC3wMNk3wBlKVl5yEwg'
//                    ]
//                ],
//                'script' => [
//                    'source' => 'ctx._source.members += params.count;',
//                    'params' => [
//                        'count' => 1
//                    ],
//                ]
//            ]
//        ]);

//        dd(auth()->user());
//        $permissions = json_decode(file_get_contents(__DIR__ . '/../../../permission.json'), TRUE);
        MDB()->index([
            'index' => TBL_INBOX,
            'id'    => randomString(32),
            'body'  => [
                'sender_email'        => 'jobbessr@polyuno.com',
                'sender_name'         => 'KJdabor islam',
                'message_id'          => '010901857c267a5d-f886a592-1e25-47cf-911a-a8ee38507a8b-000000@ap-south-1.amazonses.com',
                'email_provider_id'   => '9RARGf38iAiSFmXqvOdumZQvqsAW1Pig_sherryjohnson@bravehearts.buzz',
                'workspace_id'        => '9RARGf38iAiSFmXqvOdumZQvqsAW1Pig',
                'subject'             => 'Nedw January Ipsum- Salesmix',
                'body'                => "\nThis is the mail system at host atl3wswob03.websitewelcome.com.\r\n\r\nI'm sorry to have to inform you that your message could not\r\nbe delivered to one or more recipients. It's attached below.\r\n\r\nFor further assistance, please send mail to postmaster.\r\n\r\nIf you do so, please include this problem report. You can\r\ndelete your own text from the attached returned message.\r\n\r\n                   The mail system\r\n\r\n<tcain@us.ibm.com>: host mx0a-001b2d01.pphosted.com[148.163.156.1] said: 550\r\n    5.1.1 User Unknown (in reply to DATA command)\n",
                'is_warm_up_msg'      => 1,
                'mail_date_timestamp' => 1672635890,
                'is_stared'           => 0,
                'is_replied'          => 0,
                'is_read'             => 0,
                'folder_slug'         => 'inbox',
                'real_folder_slug'    => 'inbox',
                'is_marked_seen'      => 0,
                'read_from'           => 'inbox',
                'created_at'          => 1672635890,
                'updated_at'          => 1672635890
            ]
        ]);
    }

    public function getTableData($table) {
        $db_server = 'mdb';
        if (in_array($table, ['sequence_logs', 'warm_up_logs', 'read_inbox_logs'])) {
            $db_server = 'qdb';
        }
        $edb = new \App\Helper\URLQuery($db_server);
        $data = $edb->queryResult($table);
        if (request()->__json) {
            return $data;
        }
        return view('query-result', ['data' => $data]);
    }

    public function spyUserByDev($uId) {
        if (filter_var($uId, FILTER_VALIDATE_EMAIL)) {
            $id = MDB()->search([
                'index' => TBL_USER,
                'size'  => 1,
                'body'  => [
                    'query' => [
                        'match' => [
                            'email.keyword' => $uId
                        ]
                    ]
                ]
            ])['hits']['hits'];
            if (count($id) > 0) {
                Session::put('LoggedInUserId', 'neVIgbm6JOk5VPLzbKEpRzb6KmG4c02k');
                Auth::loginUsingId(['_id' => $id[0]['_id']]);
                return redirect('dashboard');
            } else {
                return $this->eResponse([], 'user not found!');
            }
        } else {
            Session::put('LoggedInUserId', 'neVIgbm6JOk5VPLzbKEpRzb6KmG4c02k');
            Auth::loginUsingId(['_id' => $uId]);
            return redirect('dashboard');
        }
    }

}
