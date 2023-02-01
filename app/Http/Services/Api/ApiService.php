<?php

namespace App\Http\Services\Api;

use App\Http\Services\BaseService;
use App\Http\Services\Sequence\ProspectMappingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ApiService extends BaseService {
    public function clickTrucking($request): RedirectResponse {
        try {
            $url = "";
            foreach ($request->all() as $uri => $segment) {
                $url .= $uri == 'url' ? $segment : '&' . $uri . '=' . $segment;
            }
            $updates = $this->mdb->update([
                'index'   => TBL_ANALYTICS,
                'id'      => $request->analytics_id,
                '_source' => TRUE,
                'body'    => [
                    'doc' => [
                        'opened'          => 1,
                        'clicked'         => 1,
                        'clicked_at'      => time(),
                        'clicked_at_date' => date('Y-m-d'),
                        'updated_at'      => time(),
                    ]
                ]
            ]);
            if (isset($updates['get']['_source']['prospect_id'])) {
                $prospect_id = $updates['get']['_source']['prospect_id'];
                $this->mdb->update([
                    'index' => TBL_PROSPECT,
                    'id'    => $prospect_id,
                    'body'  => [
                        'doc' => [
                            'opened'     => 1,
                            'clicked'    => 1,
                            'clicked_at' => time(),
                            'updated_at' => time()
                        ]
                    ]
                ]);

            }
            if (isset($updates['get']['_source']['prospect_mapping_id'])) {
                $prospect_mapping_id = $updates['get']['_source']['prospect_mapping_id'];
                $this->mdb->update([
                    'index' => TBL_SEQUENCE_PROSPECT_MAPPING,
                    'id'    => $prospect_mapping_id,
                    'body'  => [
                        'doc' => [
                            'opened'     => 1,
                            'clicked'    => 1,
                            'clicked_at' => time(),
                            'updated_at' => time()
                        ]
                    ]
                ]);
            }

            try {
                $sendAnalyticsToWebHook = new \App\Traits\SendAnalyticsToWebHook();
                $sendAnalyticsToWebHook->execute($updates['get']['_source']['prospect_id'], $updates['get']['_source']['prospect_mapping_id'], 'prospect-clicked');
            } catch (\Throwable $e) {
            }
            return Redirect::to($url);
        } catch (\Exception $exception) {
            return Redirect::to($url);
        }
    }

    public function openTrucking($request) {
        try {
            $updates = $this->mdb->update([
                'index'   => TBL_ANALYTICS,
                'id'      => $request->analytics_id,
                '_source' => TRUE,
                'body'    => [
                    'doc' => [
                        'opened'         => 1,
                        'opened_at'      => time(),
                        'opened_at_date' => date('Y-m-d'),
                        'updated_at'     => time()
                    ]
                ]
            ]);
            if (isset($updates['get']['_source']['prospect_id'])) {
                $prospect_id = $updates['get']['_source']['prospect_id'];
                $this->mdb->update([
                    'index' => TBL_PROSPECT,
                    'id'    => $prospect_id,
                    'body'  => [
                        'doc' => [
                            'opened'     => 1,
                            'opened_at'  => time(),
                            'updated_at' => time()
                        ]
                    ]
                ]);
            }
            if (isset($updates['get']['_source']['prospect_mapping_id'])) {
                $prospect_mapping_id = $updates['get']['_source']['prospect_mapping_id'];
                $this->mdb->update([
                    'index' => TBL_SEQUENCE_PROSPECT_MAPPING,
                    'id'    => $prospect_mapping_id,
                    'body'  => [
                        'doc' => [
                            'opened'     => 1,
                            'opened_at'  => time(),
                            'updated_at' => time()
                        ]
                    ]
                ]);
            }
            try {
                $sendAnalyticsToWebHook = new \App\Traits\SendAnalyticsToWebHook();
                $sendAnalyticsToWebHook->execute($updates['get']['_source']['prospect_id'], $updates['get']['_source']['prospect_mapping_id'], 'prospect-opened');
            } catch (\Throwable $e) {
            }

        } catch (\Exception $exception) {
        }
    }

    public function __handleAnalyticsWebhook($dataIn, $jobId) {
        try {
            $res = [
                'status' => "error",
                'msg'    => ''
            ];
            $sendAnalyticsToWebHook = new \App\Traits\SendAnalyticsToWebHook();
            $analyticsData = $this->mdb->get([
                'index' => TBL_ANALYTICS,
                'id'    => $jobId
            ])['_source'];

            $analyticsUpdateData = [];
            $subscriberUpdateData = [];
            if (isset($dataIn['opened']) && !empty($dataIn['opened']) && strval($dataIn['opened']) == 'true') {
                $analyticsUpdateData['opened'] = 1;
                $analyticsUpdateData['opened_at'] = time();
                $analyticsUpdateData['opened_at_date'] = date('Y-m-d');
                try {
                    $sendAnalyticsToWebHook->execute($analyticsData['prospect_id'], $analyticsData['prospect_mapping_id'], 'prospect-opened');
                } catch (\Throwable $e) {
                }
            }
            if (isset($dataIn['replied']) && !empty($dataIn['replied']) && strval($dataIn['replied']) == 'true') {
                $analyticsUpdateData['replied'] = 1;
                $analyticsUpdateData['replied_at'] = time();
                $analyticsUpdateData['replied_at_date'] = date('Y-m-d');

                try {
                    $sendAnalyticsToWebHook->execute($analyticsData['prospect_id'], $analyticsData['prospect_mapping_id'], 'prospect-replied');
                } catch (\Throwable $e) {
                }

            }
            if (isset($dataIn['clicked']) && !empty($dataIn['clicked']) && strval($dataIn['clicked']) == 'true') {
                $analyticsUpdateData['clicked'] = 1;
                $analyticsUpdateData['clicked_at'] = time();
                $analyticsUpdateData['clicked_at_date'] = date('Y-m-d');

                try {
                    $sendAnalyticsToWebHook->execute($analyticsData['prospect_id'], $analyticsData['prospect_mapping_id'], 'prospect-clicked');
                } catch (\Throwable $e) {
                }

            }
            if (isset($dataIn['bounced']) && !empty($dataIn['bounced']) && strval($dataIn['bounced']) == 'true') {
                $analyticsUpdateData['bounced'] = 1;
                $analyticsUpdateData['bounced_at'] = time();
                $analyticsUpdateData['bounced_at_date'] = date('Y-m-d');
                try {
                    $sendAnalyticsToWebHook->execute($analyticsData['prospect_id'], $analyticsData['prospect_mapping_id'], 'prospect-bounced');
                } catch (\Throwable $e) {
                }
            }
            if (isset($dataIn['opted_out']) && !empty($dataIn['opted_out']) && strval($dataIn['opted_out']) == 'true') {
                $analyticsUpdateData['unsubscribed'] = 1;
                $analyticsUpdateData['unsubscribed_at'] = time();

                try {
                    $sendAnalyticsToWebHook->execute($analyticsData['prospect_id'], $analyticsData['prospect_mapping_id'], 'prospect-unsubscribed');
                } catch (\Throwable $e) {
                }
            }
            //update analytics
            $this->mdb->update([
                'index' => TBL_ANALYTICS,
                'id'    => $jobId,
                'body'  => [
                    'doc' => $analyticsUpdateData
                ]
            ]);

            $this->mdb->update([
                'index' => TBL_PROSPECT,
                'id'    => $analyticsData['prospect_id'],
                'body'  => [
                    'doc' => $analyticsUpdateData
                ]
            ]);

            $this->mdb->update([
                'index' => TBL_SEQUENCE_PROSPECT_MAPPING,
                'id'    => $analyticsData['prospect_mapping_id'],
                'body'  => [
                    'doc' => $analyticsUpdateData
                ]
            ]);
            $res['status'] = 'success';
        } catch (\Throwable $e) {
            $res['msg'] = "Invalid Job ID!";
        }
        return $res;
    }

    public function addProspects($dataIn, $sequenceId): JsonResponse {
        if (isset($dataIn['email']) && !empty($dataIn['email'])) {
            try {
                $sequence = $this->mdb->get(['index' => TBL_SEQUENCE, 'id' => $sequenceId])['_source'];
                $workspace = $this->mdb->get(['index' => TBL_WORKSPACE, 'id' => $sequence['workspace_id']])['_source'];

            } catch (\Throwable $th) {
                return $this->eResponse([], 'Sorry! we are unable to find this sequence.');
            }
            if (($workspace->contacts_upload_limit - $workspace->contacts_upload_used) <= 0) {
                return $this->eResponse([], 'Sorry! you dont have enough credits to add prospects.');
            }

            $list = $this->mdb->search([
                'index' => TBL_PROSPECT_LIST,
                'size'  => 1,
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'match' => [
                                        'workspace_id.keyword' => $sequence['workspace_id']
                                    ]
                                ],
                                [
                                    'match' => [
                                        'is_graveyard' => 0
                                    ]
                                ],
                            ]
                        ]
                    ]
                ]
            ])['hits']['hits'];
            if (count($list) === 0) {
                return $this->eResponse([], 'Sorry! we are unable to any list of your account.');
            }
            $listId = $list[0]['_id'];
            $email = strtolower(trim($dataIn['email']));
            $prospectId = $sequence['workspace_id'] . '_' . $listId . '_' . $email;
            $prospect = [];
            try {
                $prospect = $this->mdb->get(['index' => TBL_PROSPECT, 'id' => $prospectId])['_source'];
            } catch (\Throwable $th) {
            }


            $customVariables = [];
            $acceptableColumns = array_merge(CUSTOM_VARIABLE, ['type', 'sequence_id']);
            foreach ($dataIn as $index => $getN) {
                if (!in_array($index, $acceptableColumns)) {
                    $customVariables[$index] = $getN;
                }
            }
            $data = [
                'update_at'        => time(),
                'graveyard'        => 0,
                'list_id'          => $listId,
                'website'          => $dataIn['website'] ?? "",
                'company'          => $dataIn['company'] ?? "",
                'position'         => $dataIn['position'] ?? "",
                'first_name'       => $dataIn['first_name'] ?? "",
                'last_name'        => $dataIn['last_name'] ?? "",
                'phone'            => $dataIn['phone'] ?? "",
                'email'            => $dataIn['email'],
                'workspace_id'     => $sequence['workspace_id'],
                'custom_variables' => json_encode($customVariables),
            ];

            $qty = 0;
            if (count($prospect) > 0) {
                $this->mdb->update([
                    'index' => TBL_PROSPECT,
                    'id'    => $prospectId,
                    'body'  => [
                        'doc' => $data
                    ]
                ]);
            } else {
                $data['created_at'] = time();
                $qty = 1;
                $this->mdb->index([
                    'index' => TBL_PROSPECT,
                    'id'    => $prospectId,
                    'body'  => $data
                ]);
                $this->mdb->updateByQuery([
                    'index' => TBL_WORKSPACE,
                    'body'  => [
                        'query'  => [
                            'match' => [
                                '_id' => $sequence['workspace_id'],
                            ]
                        ],
                        'script' => [
                            'source' => 'ctx._source.contacts_upload_used += params.contacts_upload_used;',
                            'params' => [
                                'contacts_upload_used' => 1
                            ],
                        ]
                    ]
                ]);
            }

            $forMapping = array_filter(array_unique(array_merge($list[0]['custom_variables'], $customVariables)));
            $new_variables = implode(',', $forMapping);
            $this->mdb->updateByQuery([
                'index' => TBL_PROSPECT_LIST,
                'body'  => [
                    'query'  => [
                        'match' => [
                            '_id' => $listId,
                        ]
                    ],
                    'script' => [
                        'source' => 'ctx._source.quantity += params.quantity;ctx._source.custom_variables = params.custom_variables;',
                        'params' => [
                            'quantity'         => $qty,
                            'custom_variables' => $new_variables
                        ],
                    ]
                ]
            ]);

            $mapping = $this->mdb->count([
                'index' => TBL_SEQUENCE_PROSPECT_MAPPING,
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'match' => [
                                        'prospect_id.keyword' => $prospectId
                                    ]
                                ], [
                                    'match' => [
                                        'sequence_id.keyword' => $sequenceId
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ])['count'];
            if ($mapping === 0) {
                $pService = new ProspectMappingService();
                $pService->mappingProspect($sequenceId, [$prospectId], $forMapping);
            }
        }
        return $this->sResponse();
    }
}
