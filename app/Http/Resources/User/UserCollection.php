<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return [
            // 'data' => $this->collection,
            // 'links' => 'test'
        // ];

        return parent::toArray($request);
    }

    public function paginationInformation($request, $paginated, $default) {
        $default['links']['custom'] = 'https://example.com';      
        
        return $default;
    }
}
