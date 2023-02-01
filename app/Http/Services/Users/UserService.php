<?php

namespace App\Http\Services\Users;

use App\Http\Resources\WorkspaceCollection;
use App\Http\Services\BaseService;
use App\Http\Services\GlobalService;
use App\Traits\helperTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserService  extends BaseService {
    public function __updateProfile($request): \Illuminate\Http\JsonResponse {
        try {
            $this->mdb->update([
                'index' => TBL_USER,
                'id'    => auth()->user()->_id,
                'body'  => [
                    'doc' => [
                        'company'    => $request->company,
                        'name'       => $request->name . ' ' . $request->last_name,
                        'first_name' => $request->first_name,
                        'last_name'  => $request->last_name,
                        'timezone'   => $request->timezone,
                        'website'    => $request->website,
                        'update_at'  => time()
                    ]
                ]
            ]);
            $this->saveNotification([
                'type'       => nType_profile,
                'body'       => "Your <b>profile</b> has been updated successfully!",
                'link'       => url('/settings')
            ]);
            return $this->sResponse([], 'Your profile has been updated successfully!');
        } catch (\Throwable $th) {
            return $this->eResponse([], $th->getMessage());
        }
    }
    public function __updatePassword($request): \Illuminate\Http\JsonResponse {
        try {
            $user = $this->mdb->get([
                'index' => TBL_USER,
                'id'    => auth()->user()->_id
            ])['_source'];

            if( !Hash::check($request->old,$user['password']) ){
                return $this->eResponse([],'old_password_not_match');
            }

            $this->mdb->update([
                'index' => TBL_USER,
                'id'    => auth()->user()->_id,
                'body'  => [
                    'doc' => [
                        'password'    => Hash::make($request->confirm),
                        'update_at'  => time()
                    ]
                ]
            ]);
            return $this->sResponse([], 'Your password has been changed successfully!');
        } catch (\Throwable $th) {
            return $this->eResponse([], $th->getMessage());
        }
    }
    public function __updateProfilePicture($request): \Illuminate\Http\JsonResponse {
        try {
            if (auth()->user()->profile_pic !== '/backend/images/avatar.png') {
                if (File::exists(public_path() . auth()->user()->profile_pic)) {
                    File::delete(public_path() . auth()->user()->profile_pic);
                }
            }
            $id = randomString(32);
            $path = '/backend/images/avatar.png';
            if ($request->file('uploadFile')) {
                $imagePath = $request->file('uploadFile');
                $imageName = $imagePath->getClientOriginalName();
                $imageName = $id . '.' . $request->uploadFile->getClientOriginalExtension();
                $request->uploadFile->move(public_path('/uploads/images/profile'), $imageName);
                $path = '/uploads/images/profile/' . $imageName;
            } else {
                return $this->eResponse([], 'Sorry! Image not found.');
            }
            MDB()->update([
                'index' => TBL_USER,
                'id'    => auth()->user()->_id,
                'body'  => [
                    'doc' => [
                        'profile_pic' => $path,
                        'updated_at'  => time(),
                    ]
                ]
            ]);
//            $this->saveNotifaction([
//                'title'      => "You've Successfully updated your profile picture",
//                'type'       => nType_profile,
//                'link'       => 'https://app.outreachbin.com/settings',
//                'action_btn' => "<a href='https://app.outreachbin.com/settings' class='btn btn-success px-2 py-1 fw-normal mt-3'> View Details </a>",
//            ]);
            return $this->sResponse(['path' => $path], 'Your profile picture has been updated successfully.');
        } catch (\Throwable $th) {
            return $this->eResponse([], $th->getMessage());
        }
    }
}
