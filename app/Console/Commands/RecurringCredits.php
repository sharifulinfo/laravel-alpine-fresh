<?php

namespace App\Console\Commands;

use App\Http\Controllers\BillingController;
use Illuminate\Console\Command;

class RecurringCredits extends Command {
    private $mdb;
    protected $signature = 'recurringCredit';
    protected $description = 'Recurring lifetime user & yearly user plan wise credits';

    ###------------
    public function handle() {
        $this->mdb = MDB();
        $this->processSubscriptionUser();
        $this->processLifeTimeUser();
    }

    private function processSubscriptionUser(){
        try {
            $users =$this->mdb->search([
                'index' => TBL_USER,
                'size'  => 1000,
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
                                ],
                                [
                                    'match' => [
                                        'plan_type.keyword' => 'subscription'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ])['hits']['hits'];
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $b = new BillingController();
                    $plan = $b->getPlan($user['_source']['price_id'], TRUE);
                    if(!isset($plan['interval']) || $plan['interval'] !== 'year'){
                        continue;
                    }
                    if($plan['addOnsType'] === 'salesmix') {
                        $d = $this->mdb->updateByQuery([
                            'index' => TBL_WORKSPACE,
                            'body'  => [
                                'query'  => [
                                    'match' => [
                                        'user_id.keyword' => $user['_id']
                                    ]
                                ],
                                'script' => [
                                    'source' => 'ctx._source.email_sending_used = params.email_sending_used;ctx._source.updated_at = params.updated_at;ctx._source.email_sending_limit = params.email_sending_limit;ctx._source.contacts_upload_limit = params.contacts_upload_limit;',
                                    'params' => [
                                        'updated_at'    => time(),
                                        'email_sending_used'    => 0,
                                        'email_sending_limit'   => $plan['sending_credit'] ?? 0,
                                        'contacts_upload_limit' => $plan['upload_credit'] ?? 0,
                                    ],
                                ]
                            ]
                        ]);
                    }
                    $leadPlan = $user['_source']['lead_price_id'] ?? '';
                    $verifyPlan = $user['_source']['verification_price_id'] ?? '';
                    if(!empty($leadPlan)){
                        $plan = $b->getPlan($leadPlan, TRUE);
                        if($plan['addOnsType'] === 'leads') {
                            $this->mdb->updateByQuery([
                                'index' => TBL_USER,
                                'body'  => [
                                    'query'  => [
                                        'match' => [
                                            '_id' => $user['_id']
                                        ]
                                    ],
                                    'script' => [
                                        'source' => 'ctx._source.leads_limit += params.leads_limit;',
                                        'params' => [
                                            'leads_limit'    => $plan['credits'] ?? 0,
                                        ],
                                    ]
                                ]
                            ]);
                        }
                    }
                    if(!empty($verifyPlan)){
                        $plan = $b->getPlan($verifyPlan, TRUE);
                        if($plan['addOnsType'] === 'verification') {
                            $this->mdb->updateByQuery([
                                'index' => TBL_USER,
                                'body'  => [
                                    'query'  => [
                                        'terms' => [
                                            '_id' => $user['_id']
                                        ]
                                    ],
                                    'script' => [
                                        'source' => 'ctx._source.verification_limit += params.verification_limit;',
                                        'params' => [
                                            'verification_limit'    => $plan['credits'] ?? 0,
                                        ],
                                    ]
                                ]
                            ]);
                        }
                    }
                }
            }
            print_r(count($users)." yearly users updated");
            echo "\n";
            // return $teamId;
        } catch (\Throwable $th) {
            //throw $th;
            print_r("failed");
            echo "\n";
        }
    }

    private function processLifeTimeUser(){
        try {
            $users = $this->mdb->search([
                'index' => TBL_USER,
                'size'  => 1000,
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'match' => [
                                        'plan_next_recurring_at' => date('Y-m-d')
                                    ]
                                ],
                                [
                                    'match' => [
                                        'plan_type.keyword' => 'lifetime'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ])['hits']['hits'];
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $b = new BillingController();
                    $plan = $b->getPlan($user['_source']['price_id'], TRUE);
                    if($plan['addOnsType'] === 'salesmix') {
                        $d = $this->mdb->updateByQuery([
                            'index' => TBL_WORKSPACE,
                            'body'  => [
                                'query'  => [
                                    'match' => [
                                        'user_id.keyword' => $user['_id']
                                    ]
                                ],
                                'script' => [
                                    'source' => 'ctx._source.email_sending_used = params.email_sending_used;ctx._source.updated_at = params.updated_at;ctx._source.email_sending_limit = params.email_sending_limit;ctx._source.contacts_upload_limit = params.contacts_upload_limit;',
                                    'params' => [
                                        'updated_at'    => time(),
                                        'email_sending_used'    => 0,
                                        'email_sending_limit'   => $plan['sending_credit'] ?? 0,
                                        'contacts_upload_limit' => $plan['upload_credit'] ?? 0,
                                    ],
                                ]
                            ]
                        ]);
                    }
                }
            }
            print_r(count($users)." lifetime users updated");
            echo "\n";
            // return $teamId;
        } catch (\Throwable $th) {
            //throw $th;
            print_r("failed");
            echo "\n";
        }
    }
}
