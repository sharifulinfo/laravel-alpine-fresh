<?php

namespace App\Http\Services\Admin;

use App\Http\Resources\UserCollection;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService {
    public function loadUsers($request): JsonResponse {
        $db = DB::table(TBL_USER);
        if (isset($request->filter['search']) && !empty($request->filter['search']) && $request->filter['search'] !== 'null') {
            $validMail = filter_var($request->filter['search'], FILTER_VALIDATE_EMAIL);
            if ($validMail) {
                $db->where('email',strtolower($request->filter['search']));
            } else {
                $q = strtolower($request->filter['search']);
                $db->orWhere('name', 'LIKE', '%'.$q.'%')
                      ->orWhere('email', 'LIKE', '%'.$q.'%')
                      ->orWhere('email', 'LIKE', '%'.$q.'%');
            }
        }

        if (isset($request->filter['status']) && !empty($request->filter['status'])) {
            if ($request->filter['status'] !== 'all') {
                $db->where('status', strtolower($request->filter['status']));
            }
        }
        $result = $db->paginate(2);
        $meta = [];
        $meta['pagination'] = [
            "current_page" => $result->currentPage(),
            "first_page_url" =>  $result->getOptions()['path'].'?'.$result->getOptions()['pageName'].'=1',
            "prev_page_url" =>  $result->previousPageUrl(),
            "next_page_url" =>  $result->nextPageUrl(),
            "last_page_url" =>  $result->getOptions()['path'].'?'.$result->getOptions()['pageName'].'='.$result->lastPage(),
            "last_page" =>  $result->lastPage(),
            "per_page" =>  $result->perPage(),
            "total" =>  $result->total(),
            "path" =>  $result->getOptions()['path'],
        ];
        return $this->sResponseMeta(new UserCollection($result), $meta);
    }

}
