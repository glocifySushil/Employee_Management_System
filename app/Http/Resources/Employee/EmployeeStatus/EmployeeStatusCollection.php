<?php

namespace App\Http\Resources\Employee\EmployeeStatus;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeStatusCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'total_pages' => $resource->lastPage(),
            'previous_page_url' => $resource->previousPageUrl(),
            'next_page_url' => $resource->nextPageUrl(),
            'all_pages_links' => $resource->getUrlRange($resource->currentPage(), $resource->lastPage())
            ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => $this->pagination
        ];
    }
}
