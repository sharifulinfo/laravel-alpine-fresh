<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id'                => $this->id ?? "",
            'name'              => $this->name ?? "",
            'email'             => $this->email ?? "",
            'email_verified_at' => $this->email_verified_at ?? "",
            'user_type'         => $this->user_type ?? "",
            'last_login_at'     => date("d M, h:ia", strtotime($this->last_login_at)) ?? "",
            'remember_token'    => $this->remember_token ?? "",
            'created_at'        => $this->created_at ?? "",
            'updated_at'        => $this->updated_at ?? "",
        ];
    }
}
