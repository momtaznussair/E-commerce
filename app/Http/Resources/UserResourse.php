<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar_path,
            'gender' => $this->gen,
            'dob' => $this->dob,
            'city' => new CityResource($this->city),
            'country' => new CountryResource($this->city->country),
            'phone' => $this->phone
        ];
    }
}
