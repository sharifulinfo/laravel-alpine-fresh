<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\ApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApiController extends Controller {
    private ApiService $apiService;

    function __construct() {
        $this->apiService = new ApiService();
    }

    public function clicked(Request $request): RedirectResponse {
        return $this->apiService->clickTrucking($request);
    }

    public function opened(Request $request) {
        $this->apiService->openTrucking($request);
    }

    public function handleAnalyticsWebHook(Request $request, $jobId): array {
        $dataIn = $request->all();
        if (isset($dataIn) && count($dataIn) == 0) {
            $dataIn = json_decode($request->getContent(), TRUE);
        }
        if (isset($jobId) && !empty($jobId) && !empty($dataIn)) {
            return $this->apiService->__handleAnalyticsWebhook($dataIn, $jobId);
        }
        return [
            'status' => "error",
            'msg'    => ''
        ];
    }

    public function hanldeIncomingWebhook(Request $request, $sequenceId) {
        $res = [
            'status' => "error",
            'msg'    => ''
        ];
        $dataIn = $request->all();
        if(isset($dataIn) && !empty($dataIn) && is_array($dataIn) && count($dataIn) > 0){ }else{
            $dataIn = json_decode($request->getContent(), TRUE);
        }
        ##process data
        $type = '';
        if(isset($dataIn['type']) && !empty($dataIn['type'])){
            $type = $dataIn['type'];
        }
        if($type == 'add-single-prospect'){

            return $this->apiService->addProspects($dataIn,$sequenceId);


        }
        return $res;
    }
}
