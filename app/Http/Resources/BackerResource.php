<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BackerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'=>(string) $this->id,
            'type'=>'user',
            'pledge_amount'=>$this->pledge_amount,
            'pledge_date'=>$this->pledge_date,
            'user_id'=>$this->user_id,
            'project_id'=>$this->project_id,
            'name'=>$this->user_id->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'National_id'=>$this->National_id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'role'=>$this->role,
        ];

    }
}
