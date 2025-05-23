<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'price' => number_format($this->price/100 ,2) , 
            'category' => CategoryResource::make($this->whenLoaded('category')), // عرضت الكاتيجوري ريسوري عرضت الاسم و الايد فقط 
        ];
        // return parent::toArray($request);
    }
}
