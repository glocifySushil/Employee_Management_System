<?php

namespace App\Http\Resources\Employee\EmployeeDepartment;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDepartmentResource extends JsonResource
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
            'id' => $this->id,
            'department' => $this->department,
            'description' => $this->description,
        ];
    }
}
