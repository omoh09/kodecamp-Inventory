<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'productName' => $this->name,
            'productDesc' => $this->description ?? "",
            'productPrice' => $this->price,
            'productQuantity' => $this->quantity,
            'productItemNumber' => $this->ItemNumber,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'productImage' => FileResources::make($this->files)
        ];
    }
}
